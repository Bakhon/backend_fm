<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseVersionRequest;
use App\Http\Requests\CaseVersionStatusRequest;
use App\Http\Resources\CaseVersionResource;
use App\Services\CaseVersionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

/**
 * @OA\Tag(
 *     name="CaseVersions",
 *     description="Case version endpoints"
 * )
 */
class CaseVersionController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/api/case-versions",
     *     tags={"CaseVersions"},
     *     description="Get list of cases with search",
     *     @OA\Parameter(in="query", name="case_hash", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="version", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response="200", description="Return sections list",
     *      @OA\JsonContent(ref="#/components/schemas/CaseVersionResource")
     *     ),
     *     @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     *)
     * @param CaseVersionService $caseVersionService
     * @param CaseVersionRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function index(CaseVersionService $caseVersionService, CaseVersionRequest $request): JsonResponse
    {
        $response = $caseVersionService->_list($request);
        return $this->successResponseWithData(CaseVersionResource::collection($response));
    }

    /**
     * @OA\Put(
     *     path="/api/case-versions/{hash}",
     *     tags={"CaseVersions"},
     *     description="Update status CaseVersion",
     *     @OA\Parameter(description="CaseVersion hash", in="path", name="hash", required=true, @OA\Schema(type="string")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/CaseVersionStatusRequest")),
     *     @OA\Response(response="200",description="Category sucsessfully change"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param string $hash
     * @param CaseVersionStatusRequest $request
     * @param CaseVersionService $caseVersionService
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(string $hash, CaseVersionStatusRequest $request, CaseVersionService $caseVersionService): JsonResponse
    {
        $caseVersionService->changeStatus($hash, $request);
        return $this->successResponse(Response::HTTP_OK);
    }
}
