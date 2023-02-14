<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Http\Requests\ReportInitRequest;
use App\Http\Requests\ReportSearchRequest;
use App\Http\Resources\ReportResource;
use App\Models\BICase;
use App\Models\CaseVersion;
use App\Models\Report;
use App\Models\ReportFamily;
use App\Reference\Constants;
use App\Reference\ReportConstants;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ReportService
 * @package App\Services
 */
class ReportService extends Service
{
    /**
     * Get reports with relations by filter
     *
     * @param ReportSearchRequest $request
     * @return array
     */
    public function _list(ReportSearchRequest $request): array
    {
        $query = Report::where([]);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if (is_numeric($request->status_id)) {
            $query->whereHas('reportFamilies', function ($query) use ($request) {
                return $query->where(['status_id' => $request->status_id]);
            });
        }

        if ($request->date_created_from) {
            $query->where('created_at', '>=', Carbon::parse($request->date_created_from));
        }

        if ($request->date_created_from) {
            $query->where('created_at', '<', Carbon::parse($request->date_created_to)->addDay());
        }

        if ($request->user_hash) {
            $query->where(['user_hash' => $request->user_hash]);
        }

        $queryCount = $query->count();

        if (!$request->without_limit) {
            $query->limit($request->limit)
                ->offset($request->offset);
        }

        $query->orderBy($request->order_by ?? 'created_at', $request->direction ?? 'desc');

        return [
            'list' => ReportResource::collection($query->get()),
            'listCount' => $queryCount,
        ];
    }

    /**
     * Init report
     *
     * @param ReportInitRequest $request
     * @return ReportResource
     * @throws ApiException
     */
    public function init(ReportInitRequest $request): ReportResource
    {
        try {
            DB::beginTransaction();

            $families_count = 0;
            $family_errors = 0;

            $report = new Report();
            $report->name = $request->project;
            $report->guid = Uuid::fromDateTime(Carbon::now()->toDateTime());
            $report->user_hash = $this->getUser()->sub;

            if (!$report->save()) {
                throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $report->url = config('app.url_front') . '/reports/' . $report->id;

            foreach ($request->families as $family) {

                $case = BICase::withTrashed()->where(['guid' => $family->guid])->first();

                $reportFamily = new ReportFamily();
                $reportFamily->name = $family->family_name;
                $reportFamily->guid = $family->guid;
                $reportFamily->version = $family->version;
                $reportFamily->report_id = $report->id;
                $reportFamily->family_id = $case ? $case->id : null;
                $reportFamily->current_version = $case ? $case->version : null;

                $reportFamily->url = $case ? config('app.url_front') . '/family/' . $case->id : null;
                $families_count++;

                $reportFamily->status_id = $this->getReportFamilyStatus($reportFamily, $case);

                if ($reportFamily->status_id !== ReportConstants::REGISTERED_AND_RELEVANT) {
                    $family_errors++;
                }

                if (!$reportFamily->save()) {
                    throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

            $report->families_count = $families_count;
            $report->family_errors = $family_errors;

            if (!$report->save()) {
                throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw new ApiException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $report->load('reportFamilies');

        return new ReportResource($report);
    }

    /**
     * Get single report
     *
     * @param Report $report
     * @return ReportResource
     */
    public function show(Report $report): ReportResource
    {
        $report->load('reportFamilies');
        return new ReportResource($report);
    }

    /**
     * Get report family status
     *
     * @param ReportFamily $reportFamily
     * @param BICase|null $case
     * @return int
     */
    public function getReportFamilyStatus(ReportFamily $reportFamily, ?BICase $case): int
    {
        if (!$case) {
            return ReportConstants::NOT_REGISTERED;
        }

        if ($case->deleted_at || !$this->rfaStatusActive($case)) {
            return ReportConstants::REGISTERED_AND_IRRELEVANT;
        }

        if ($reportFamily->version !== $case->version) {
            return ReportConstants::REGISTERED_AND_OUTDATED;
        }

        if ($reportFamily->name !== $case->name) {
            return ReportConstants::REGISTERED_WITHOUT_NAME_COINCIDENCE;
        }

        return ReportConstants::REGISTERED_AND_RELEVANT;
    }

    /**
     * Get report users from keyCloak
     *
     * @return AnonymousResourceCollection
     * @throws Throwable
     */
    public function authors(): AnonymousResourceCollection
    {
        $authors = Report::select(['user_hash'])->groupBy('user_hash')->get();
        $keyCloakUsers = $this->keyCloakService->getKeyCloakUsers();

        return $this->mergeUsers($keyCloakUsers, $authors, 'user_hash');
    }

    /**
     * @param Report $report
     * @return bool
     * @throws Throwable
     */
    public function delete(Report $report): bool
    {
        if (!$report->delete()) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return true;
    }

    /**
     * get rfa status active
     *
     * @param BICase $case
     * @return bool
     */
    public function rfaStatusActive(BICase $case): bool
    {
        $caseVersions = $this->caseVersionService->getCaseVersions($case->id);

        /** @var CaseVersion $caseVersion */
        foreach ($caseVersions as $caseVersion) {
            if ($caseVersion->type_id === Constants::RFA_TYPE_ID) {
                return $caseVersion->is_active;
            }
        }

        return false;
    }
}
