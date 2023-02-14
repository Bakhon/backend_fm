<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Http\Requests\FileCaseRequest;
use App\Http\Requests\FileRequest;
use App\Models\CaseVersion;
use App\Models\File;
use App\Reference\CaseConstants;
use App\Reference\Constants;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

/**
 * Class FileService
 * @package App\Services
 */
class FileService extends Service
{
    /**
     * Save new file
     *
     * @param FileRequest $request
     * @return bool
     * @throws Throwable
     */
    public function saveFile(FileRequest $request): bool
    {
        $requestFile = $request->file;

        $hash = strtoupper(hash("sha256", $requestFile->get()));

        /** @var CaseVersion $caseVersion */
        $caseVersion = CaseVersion::where(['hash' => $hash])->first();

        if (!$caseVersion) {
            throw new ApiException(Constants::ERROR_CASE_FILE_HASH_NOT_FOUND, Response::HTTP_BAD_REQUEST);
        }

        /** @var File $file */
        $file = File::where(['hash' => $hash])->first();
        if ($file) {
            throw new ApiException(Constants::ERROR_FILE_ALREADY_EXIST, Response::HTTP_BAD_REQUEST);
        }

        try {
            DB::beginTransaction();

            $extension = trim($requestFile->getClientOriginalExtension());
            $guid = Str::uuid();

            $fileName = $hash . '.' . $extension;
            $filePath = Storage::disk('cases')->put($fileName, file_get_contents($requestFile));

            $file = new File();

            $file->hash = $hash;
            $file->path = $filePath;
            $file->name = $guid;
            $file->extension = $extension;
            $file->original_name = $requestFile->getClientOriginalName();
            $file->mime_type = $requestFile->getClientMimeType();
            $file->user_hash = $this->getUser()->sub;
            $file->case_file_id = $caseVersion->id;

            if (!$file->save()) {
                throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_BAD_REQUEST);
            }

            $caseVersions = $this->caseVersionService->getCaseVersions($caseVersion->BLCase->id);
            foreach ($caseVersions as $caseVersion) {
                $this->caseVersionService->changeVersion($caseVersion);
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw new ApiException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return true;
    }

    /**
     * Return case file by hash
     *
     * @param string $fileHash
     * @return File
     * @throws Throwable
     */
    public function getCaseFile(string $fileHash): File
    {
        /** @var File $file */
        $file = File::where(['hash' => $fileHash])->first();

        if (!$file) {
            throw new ApiException(Constants::ERROR_FILE_NOT_FOUND, Response::HTTP_BAD_REQUEST);
        }

        return $file;
    }

    /**
     * Add file in case
     *
     * @param FileCaseRequest $request
     * @return bool
     * @throws Throwable
     */
    public function addCaseFile(FileCaseRequest $request): bool
    {
        try {
            DB::beginTransaction();

            $case = $this->caseService->getByHashOrFail($request->case_hash);

            $requestFile = $request->file;
            $hash = strtoupper(hash("sha256", $requestFile->get()));
            $extension = trim($requestFile->getClientOriginalExtension());

            $caseVersion = $this->caseVersionService->getCaseVersion($case->id, $hash);

            $familyComposition = $this->familyCompositionService
                ->getFamilyCompositionByExtension($extension, $requestFile->getClientOriginalName());

            if ($familyComposition->id === Constants::RFA_TYPE_ID) {
                throw new ApiException(CaseConstants::ERROR_FORBIDDEN_UPLOAD_RFA_FILE, Response::HTTP_BAD_REQUEST);
            }

            if (!$caseVersion) {

                $caseVersion = $this->caseVersionService->createCaseVersion(
                    $case,
                    $hash,
                    $requestFile->getClientOriginalName(),
                    null,
                    $familyComposition->id
                );
            }

            $file = File::where(['hash' => $hash])->first();
            if (!$file) {
                $guid = Str::uuid();

                $fileName = $hash . '.' . $extension;
                $filePath = Storage::disk('cases')->put($fileName, file_get_contents($requestFile));

                $file = new File();

                $file->hash = $hash;
                $file->path = $filePath;
                $file->name = $guid;
                $file->extension = $extension;
                $file->original_name = $requestFile->getClientOriginalName();
                $file->mime_type = $requestFile->getClientMimeType();
                $file->user_hash = $this->getUser()->sub;
                $file->case_file_id = $caseVersion->id;

                if (!$file->save()) {
                    throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_BAD_REQUEST);
                }
            }

            $this->caseVersionService->changeVersion($caseVersion);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw new ApiException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return true;
    }
}
