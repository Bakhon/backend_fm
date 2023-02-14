<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Http\Requests\CaseFileRequest;
use App\Http\Requests\CaseVersionRequest;
use App\Http\Requests\CaseVersionStatusRequest;
use App\Models\BICase;
use App\Reference\Constants;
use Illuminate\Http\Response;
use App\Models\CaseVersion;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CaseVersionService
 * @package App\Services
 */
class CaseVersionService extends Service
{

    /**
     * Get list case version by case and version
     *
     * @param CaseVersionRequest $request
     * @return Builder[]|Collection
     * @throws Throwable
     */
    public function _list(CaseVersionRequest $request)
    {
        $case = $this->caseService->getByHashOrFail($request->case_hash);
        return CaseVersion::where(['case_id' => $case->id])->get();
    }

    /**
     * @param int $caseId
     * @return Builder[]|Collection
     */
    public function getAllByCaseId(int $caseId)
    {
        return CaseVersion::where(['case_id' => $caseId])->orderBy('id')->with('familyComposition')->get();
    }

    /**
     * Add new file in case version
     *
     * @param CaseFileRequest $file
     * @param BICase $case
     * @throws Throwable
     */
    public function addCaseFile(CaseFileRequest $file, BICase $case)
    {
        $file->Hash = strtoupper($file->Hash);
        if ($file->HashAfter) {
            $file->HashAfter = strtoupper($file->HashAfter);
        }

        $newHash = $file->HashAfter ? $file->HashAfter : $file->Hash;

        /** @var CaseVersion $caseVersion */
        $caseVersion = CaseVersion::where([
            'hash' => $file->Hash,
            'type_id' => $file->CaseItemTypeId,
            'case_id' => $case->id
        ])->first();

        if ($newHash !== $file->Hash && !$caseVersion) {
            /** @var CaseVersion $caseVersion */
            $caseVersion = CaseVersion::where([
                'hash' => $file->HashAfter,
                'type_id' => $file->CaseItemTypeId,
                'case_id' => $case->id
            ])->first();
        }

        if (!$caseVersion) {
            $caseVersion = new CaseVersion();
            $caseVersion->case_id = $case->id;
            $caseVersion->type_id = $file->CaseItemTypeId;
        }

        $caseVersion->version = $this->getCountCaseFiles($case, $file->CaseItemTypeId) + 1;
        $caseVersion->hash = $newHash;
        $caseVersion->name = $file->Name;
        $caseVersion->meta_data = json_encode($file->MetaData);

        if (!$caseVersion->save()) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param BICase $case
     * @param int $type_id
     * @return int
     */
    public function getCountCaseFiles(BICase $case, int $type_id): int
    {
        return CaseVersion::withTrashed()->where(['case_id' => $case->id, 'type_id' => $type_id])->count();
    }

    /**
     * Change case version version
     *
     * @param CaseVersion $caseVersion
     * @throws Throwable
     */
    public function changeVersion(CaseVersion $caseVersion)
    {
        $case = $caseVersion->BLCase;

        $caseVersionFilesCount = CaseVersion::withTrashed()->where(['case_id' => $case->id, 'type_id' => $caseVersion->type_id])->count();

        if ($caseVersion->file) {
            $caseVersion->version = $caseVersionFilesCount;
            if (!$caseVersion->save()) {
                throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_BAD_REQUEST);
            }
        }

        if ($caseVersion->familyComposition->extension === 'rfa') {
            $case = $caseVersion->BLCase;
            $case->version = $caseVersionFilesCount;

            if (!$case->save()) {
                throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * Check file in case
     *
     * @param int $caseId
     * @param string $fileHash
     * @throws Throwable
     */
    public function checkCaseFile(int $caseId, string $fileHash): void
    {
        $caseVersion = CaseVersion::withTrashed()->where(['hash' => $fileHash, 'case_id' => $caseId])->first();

        if (!$caseVersion) {
            throw new ApiException(Constants::ERROR_CASE_FILE_NOT_FOUND, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Get CaseVersion
     *
     * @param int $caseId
     * @param string $fileHash
     * @return CaseVersion|null
     */
    public function getCaseVersion(int $caseId, string $fileHash): ?CaseVersion
    {
        /** @var CaseVersion $caseVersion */
        $caseVersion = CaseVersion::withTrashed()->where(['hash' => $fileHash, 'case_id' => $caseId])->first();
        return $caseVersion;
    }

    /**
     * Get CaseVersions by BICase ID
     *
     * @param int $caseId
     * @return Builder[]|Collection
     */
    public function getCaseVersions(int $caseId)
    {
        return CaseVersion::whereIn('id', function ($query) use ($caseId) {
            $query->select(DB::raw('MAX(id)'))
                ->from(CaseVersion::tableName())
                ->where(['case_id' => $caseId])
                ->where(['is_active' => true])
                ->groupBy('type_id');
        })->with('familyComposition')->get();
    }

    /**
     * Create CaseVersion
     *
     * @param BICase $case
     * @param string $fileHash
     * @param string $fileName
     * @param $fileMetaData
     * @param int $familyCompositionId
     * @return CaseVersion
     * @throws Throwable
     */
    public function createCaseVersion(BICase $case, string $fileHash, string $fileName, $fileMetaData, int $familyCompositionId): CaseVersion
    {
        $caseVersion = new CaseVersion();
        $caseVersion->case_id = $case->id;
        $caseVersion->type_id = $familyCompositionId;

        $caseVersion->version = $this->getCountCaseFiles($case, $familyCompositionId) + 1;
        $caseVersion->hash = $fileHash;
        $caseVersion->name = $fileName;
        $caseVersion->meta_data = json_encode($fileMetaData);

        if (!$caseVersion->save()) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $caseVersion;
    }

    /**
     * CaseVersion change status
     *
     * @param string $caseVersionHash
     * @param CaseVersionStatusRequest $request
     * @return void
     * @throws Throwable
     */
    public function changeStatus(string $caseVersionHash, CaseVersionStatusRequest $request): void
    {
        /** @var CaseVersion $caseVersion */
        $caseVersion = CaseVersion::where(['hash' => $caseVersionHash, 'case_id' => $request->case_id])->firstOr();

        if ($caseVersion->is_active !== $request->is_active) {
            $caseVersion->is_active = $request->is_active;
            if (!$caseVersion->save()) {
                throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
