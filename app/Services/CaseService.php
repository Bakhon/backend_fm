<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Http\Requests\CaseInitRequest;
use App\Http\Requests\CaseRequest;
use App\Http\Requests\CaseSearchRequest;
use App\Http\Requests\CaseUpdateRequest;
use App\Http\Resources\CaseFileCheckResource;
use App\Http\Resources\CaseSearchResource;
use App\Http\Resources\UserResource;
use App\Models\BICase;
use App\Models\CaseVersion;
use App\Reference\CaseConstants;
use App\Reference\Constants;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Throwable;

/**
 * Class CaseService
 * @package App\Services
 */
class CaseService extends Service
{
    /**
     * Get list cases with search
     *
     * @param CaseSearchRequest $request
     * @return array
     * @throws Throwable
     */
    public function _list(CaseSearchRequest $request): array
    {
        $query = BICase::where([]);

        if ($request->search) {
            $query->where('name', 'ilike', '%' . $request->search . '%');
        }

        if ($request->category_id) {
            $query->where(['category_id' => $request->category_id]);
        }

        if ($request->service_id) {
            $query->where(['service_id' => $request->service_id]);
        }

        if ($request->status_id === CaseConstants::STATUS_WITH_TRASHED) {
            $query->withTrashed();
        }

        if ($request->status_id === CaseConstants::STATUS_ONLY_TRASHED) {
            $query->onlyTrashed();
        }

        if ($request->date_from) {
            $query->where('created_at', '>=', Carbon::parse($request->date_from));
        }

        if ($request->date_to) {
            $query->where('created_at', '<', Carbon::parse($request->date_to)->addDay());
        }

        $queryCount = $query->count();

        $query->limit($request->limit)
            ->offset($request->offset);

        $query->with(['category', 'section']);

        if (!$request->order_by) {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy($request->order_by, $request->direction ?? 'asc');
        }

        $response = [];
        /** @var BICase $case */
        foreach ($query->get() as $case) {
            $caseSearchResource = $this->caseResponse($case);

            $response[] = $caseSearchResource;
        }

        return [
            'list' => $response,
            'listCount' => $queryCount
        ];
    }

    /**
     * Create case response
     *
     * @param BICase $case
     * @param bool $withAuthor
     * @return CaseSearchResource
     * @throws Throwable
     */
    public function caseResponse(BICase $case, bool $withAuthor = false): CaseSearchResource
    {
        $type_collection_rfa = [];
        $type_collection_txt = [];
        $file_size = null;
        $category_revit = null;
        $family_placement = null;
        $shared_parameters = null;
        $family_template = null;
        $system_parameters = null;
        $count_subfamily = null;
        $count_connector = null;

        $case->caseVersions = $this->caseVersionService->getCaseVersions($case->id);
        $case->caseAllVersions = $this->caseVersionService->getAllByCaseId($case->id);

        foreach ($case->caseVersions as $caseVersion) {
            if ($caseVersion->type_id === Constants::RFA_TYPE_ID) {
                $meta_data = json_decode($caseVersion->meta_data);
                $type_collection_rfa = $meta_data->MetaDoc->TypeCollection ?? [];
                $file_size = $meta_data->MetaFile->FileSize ?? null;
                $category_revit = $meta_data->MetaDoc->Category ?? null;
                $family_placement = $meta_data->MetaDoc->FamilyPlacment ?? null;
                $shared_parameters = $meta_data->MetaDoc->Count_SharedParameters ?? null;
                $family_template = $meta_data->MetaDoc->FamilyTemplate ?? null;
                $system_parameters = $meta_data->MetaDoc->Count_NonSharedParameters ?? null;
                $count_subfamily = $meta_data->MetaDoc->Count_SubFamily ?? null;
                $count_connector = $meta_data->MetaDoc->Count_ConnectorElements ?? null;
            }

            if ($caseVersion->type_id === Constants::TXT_TYPE_ID) {
                $meta_data = json_decode($caseVersion->meta_data);
                $type_collection_txt = $meta_data ?? [];
            }
        }

        $case->type_collection = $this->arrayMerge($type_collection_rfa, $type_collection_txt);
        asort($case->type_collection);
        $case->file_size = $file_size;
        $case->category_revit = $category_revit;
        $case->family_placement = $family_placement;
        $case->shared_parameters = $shared_parameters;
        $case->family_template = $family_template;
        $case->system_parameters = $system_parameters;
        $case->count_subfamily = $count_subfamily;
        $case->count_connector = $count_connector;

        if ($withAuthor) {
            $case->author = new UserResource($this->keyCloakService->getKeyCloakUser($case->user_hash));
        }

        return new CaseSearchResource($case);
    }

    /**
     * Get single case by ID
     *
     * @param $id
     * @return CaseSearchResource
     * @throws Throwable
     */
    public function show($id): CaseSearchResource
    {
        $case = BICase::withTrashed()->where(['id' => $id])->first();

        if (!$case) {
            throw new ApiException(Constants::ERROR_CASE_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        $case->load(['category', 'section']);

        return $this->caseResponse($case, true);
    }

    /**
     * Create new BICase or update
     *
     * @param CaseRequest $request
     * @return BICase
     * @throws Throwable
     */
    public function create(CaseRequest $request): BICase
    {
        $request->CaseHashBefore = strtoupper($request->CaseHashBefore);
        if ($request->CaseHashAfter) {
            $request->CaseHashAfter = strtoupper($request->CaseHashAfter);
        }

        $case = BICase::withTrashed()->where(['name' => $request->CaseName])->first();

        if (!$case && $request->CaseHashAfter && $request->CaseHashAfter !== $request->CaseHashBefore) {
            throw new ApiException(Constants::ERROR_CASE_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        try {
            DB::beginTransaction();

            if (!$case) {
                $caseNew = new BICase();
                $caseNew->guid = Uuid::fromDateTime(Carbon::now()->toDateTime());
                $caseNew->category_id = $request->CategoryID;
                $caseNew->section_id = $request->SectionID;
                $caseNew->name = trim($request->CaseName);
                $caseNew->version = 1;
                $caseNew->user_hash = $this->getUser()->sub;
            } else {
                $caseNew = $case;
            }

            $caseNew->key = trim($request->CaseHashAfter ? $request->CaseHashAfter : $request->CaseHashBefore);
            $caseNew->category_id = $request->CategoryID;
            $caseNew->section_id = $request->SectionID;

            if (!$caseNew->save()) {
                throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            if ($request->Files) {
                foreach ($request->Files as $file) {
                    $this->caseVersionService->addCaseFile($file, $caseNew);
                }
            }

            $caseVersions = $this->caseVersionService->getCaseVersions($caseNew->id);
            foreach ($caseVersions as $caseVersion) {
                $this->caseVersionService->changeVersion($caseVersion);
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw new ApiException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        /** @var BICase $resp */
        $resp = BICase::withTrashed()->where(['id' => $caseNew->id])->first();
        $resp->caseVersions = $caseVersions;

        return $resp;
    }

    /**
     * Update case
     *
     * @param BICase $case
     * @param CaseUpdateRequest $request
     * @return CaseSearchResource
     * @throws Throwable
     */
    public function update(BICase $case, CaseUpdateRequest $request): CaseSearchResource
    {
        if ($case->name !== $request->name) {
            $caseExist = BICase::withTrashed()->where(['name' => $request->name])->first();

            if ($caseExist) {
                throw new ApiException(Constants::ERROR_CASE_NAME_ALREADY_EXIST, Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        $case->name = $request->name;
        $case->category_id = $request->category_id;
        $case->section_id = $request->section_id;

        if (!$case->save()) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $case->load(['category', 'section']);

        return $this->caseResponse($case, true);
    }

    /**
     * Check BICase
     *
     * @param CaseRequest $request
     * @return BICase
     */
    public function check(CaseRequest $request): BICase
    {
        /** @var BICase $case */
        $case = BICase::withTrashed()->where(['name' => $request->CaseName])->first();

        if (!$case) {
            $case = new BICase();
            $case->name = trim($request->CaseName);
            $case->key = trim($request->CaseHashBefore);
            $case->category_id = $request->CategoryID;
            $case->section_id = $request->SectionID;
            $case->guid = Uuid::fromDateTime(Carbon::now()->toDateTime());
            $case->version = 0;
        }

        $files = [];
        foreach ($request->Files as $file) {

            $is_load = false;
            $version = null;

            $fileHash = $file->HashAfter ? $file->HashAfter : $file->Hash;

            if ($case->id) {
                /** @var CaseVersion $caseVersion */
                $caseVersion = CaseVersion::where(['case_id' => $case->id, 'hash' => $fileHash])->first();

                if ($caseVersion) {
                    $version = $caseVersion->version;
                    $is_load = $caseVersion->file ? true : false;
                }
            }

            $resp = new CaseFileCheckResource($file);
            $resp->name = $file->Name;
            $resp->hash = $fileHash;
            $resp->type_id = $file->CaseItemTypeId;
            $resp->is_load = $is_load;
            $resp->version = $version;

            $files[] = $resp;
        }

        $case->files = $files;

        return $case;
    }

    /**
     * Destroy case
     *
     * @param BICase $case
     * @return bool
     * @throws Throwable
     */
    public function delete(BICase $case): bool
    {
        if (!$case->delete()) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return true;
    }

    /**
     * Restore case
     *
     * @param int $id
     * @return CaseSearchResource
     * @throws Throwable
     */
    public function restore(int $id): CaseSearchResource
    {
        $case = BICase::withTrashed()->where(['id' => $id])->first();

        if (!$case) {
            throw new ApiException(Constants::ERROR_CASE_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        if ($case->deleted_at && !$case->restore()) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $case->load(['category', 'section']);

        return $this->caseResponse($case, true);
    }

    /**
     * Init case
     *
     * @param CaseInitRequest $request
     * @return CaseSearchResource
     * @throws Throwable
     */
    public function init(CaseInitRequest $request): CaseSearchResource
    {
        $case = BICase::withTrashed()->where(['name' => $request->name])->first();

        if ($case) {
            throw new ApiException(Constants::ERROR_CASE_NAME_ALREADY_EXIST, Response::HTTP_NOT_FOUND);
        }

        $case = new BICase();
        $case->guid = Uuid::fromDateTime(Carbon::now()->toDateTime());
        $case->category_id = $request->category_id;
        $case->section_id = $request->section_id;
        $case->name = trim($request->name);
        $case->version = 1;
        $case->user_hash = $this->getUser()->sub;

        if (!$case->save()) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->caseResponse($case, true);
    }

    /**
     * Get case by GUID
     *
     * @param string $guid
     * @return CaseSearchResource
     * @throws Throwable
     */
    public function getByGuid(string $guid): CaseSearchResource
    {
        $case = $this->getByHashOrFail($guid);
        return $this->show($case->id);
    }

    /**
     * Get case by hash or fail
     *
     * @param string $hash
     * @return BICase
     * @throws Throwable
     */
    public function getByHashOrFail(string $hash): BICase
    {
        /** @var BICase $case */
        $case = BICase::withTrashed()->where(['guid' => $hash])->first();

        if (!$case) {
            throw new ApiException(Constants::ERROR_CASE_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        return $case;
    }
}
