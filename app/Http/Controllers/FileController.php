<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileCaseRequest;
use App\Http\Requests\FileRequest;
use App\Services\CaseService;
use App\Services\CaseVersionService;
use App\Services\FileService;
use App\Models\File;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\KeyCloakService;
use Carbon\Carbon;
use App\Services\MetricsService;
use Illuminate\Support\Facades\Cache;


/**
 * @OA\Tag(
 *     name="Files",
 *     description="File endpoints"
 * )
 */
class FileController extends ApiController
{
    /**
     * @OA\Post (
     *     path="/api/files/upload",
     *     tags={"Files"},
     *     description="Upload file",
     *     	@OA\RequestBody (
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="file", type="file", @OA\Schema(type="file"))
     *              ),
     *          ),
     *     ),
     *     @OA\Response(response="200", description="File successfully upload"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param FileRequest $request
     * @param FileService $fileService
     * @return JsonResponse
     * @throws Throwable
     */
    public function upload(FileRequest $request, FileService $fileService): JsonResponse
    {
        $fileService->saveFile($request);
        return $this->successResponse(HttpResponse::HTTP_OK);
    }

    /**
     * @OA\Get (
     *     path="/api/files/{caseHash}/{fileHash}",
     *     tags={"Files"},
     *     description="Get file by hash and case hash",
     *     @OA\Parameter(description="Case hash", in="path", name="caseHash", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(description="File hash", in="path", name="fileHash", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response="200", description="Return file"),
     *     @OA\Response(response=403, description="USER_HAS_NO_PERMISSION")
     * )
     * @param $caseHash$this->getUser()->sub
     * @param $fileHash
     * @param FileService $fileService
     * @param CaseService $caseService
     * @param CaseVersionService $caseV
     * @return HttpResponse
     * @throws Throwable
     */
    public function get($caseHash, $fileHash, MetricsService $metricsService, FileService $fileService, CaseService $caseService, CaseVersionService $caseVersionService): HttpResponse
    {
        $value = Cache::get('sub');

        $case = $caseService->getByHashOrFail($caseHash);
        
        $caseVersionService->checkCaseFile($case->id, $fileHash);

        $file = $fileService->getCaseFile($fileHash);

        $fileStorage = Storage::disk('cases')->get($file->hash . '.' . $file->extension);

        if($file){
            DB::table('files')->where('hash', '=', $fileHash)
            ->where('extension', '=', 'rfa')
            ->limit(1)
            ->update(['count' => ($file->count) + 1]); 
        }

        $metricsService->addUserFiles($file, $value);

        $headers = [
            'Content-type' => $file->mime_type,
            'Content-Encoding' => 'UTF-8',
            'transfer-encoding' => 'UTF-8',
            'Content-Disposition' => 'attachment; filename=' . $case->name . '.' . $file->extension,
        ];

        return Response::make($fileStorage, 200, $headers);
    }

    /**
     * @OA\Post (
     *     path="/api/files/case/upload",
     *     tags={"Files"},
     *     description="Upload file for case",
     *     	@OA\RequestBody (
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="file", type="file", @OA\Schema(type="file")),
     *                  @OA\Property(property="case_hash", type="string"),
     *              ),
     *          ),
     *     ),
     *     @OA\Response(response="200", description="File successfully upload"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param FileCaseRequest $request
     * @param FileService $fileService
     * @return JsonResponse
     * @throws Throwable
     */
    public function caseFileUpload(FileCaseRequest $request, FileService $fileService): JsonResponse
    {
        $fileService->addCaseFile($request);
        return $this->successResponse(HttpResponse::HTTP_OK);
    }

    public function downloadPlugin() : HttpResponse
    {
        $fileStorage = Storage::disk('cases')->get('FamilyManager.7z');
        
        $headers = [
            'Content-type' => 'application/octet-stream',
            'Content-Encoding' => 'UTF-8',
            'transfer-encoding' => 'UTF-8',
            'Content-Disposition' => 'attachment; filename=FamilyManager.7z',
        ];

        return Response::make($fileStorage, 200, $headers);
    }
}
