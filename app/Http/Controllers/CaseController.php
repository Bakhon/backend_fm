<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseInitRequest;
use App\Http\Requests\CaseRequest;
use App\Http\Requests\CaseSearchRequest;
use App\Http\Requests\CaseUpdateRequest;
use App\Http\Resources\CaseCheckResource;
use App\Http\Resources\CaseResource;
use App\Models\BICase;
use App\Services\CaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

/**
 * @OA\Tag(
 *     name="Cases",
 *     description="Case endpoints"
 * )
 */
class CaseController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/api/cases",
     *     tags={"Cases"},
     *     description="Get list of cases with search",
     *     @OA\Parameter(in="query", name="search", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="category_id", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="service_id", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="status_id", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="date_from", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="date_to", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="order_by", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(in="query", name="direction", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(description="List limit", in="query", name="limit", required=false, example=10, @OA\Schema(type="integer")),
     *     @OA\Parameter(description="Offset", in="query", name="offset", required=false, example=0, @OA\Schema(type="integer")),
     *     @OA\Response(response="200", description="Return case list",
     *      @OA\JsonContent(ref="#/components/schemas/CaseSearchResource")
     *     ),
     *     @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     *)
     * @param CaseService $service
     * @param CaseSearchRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function index(CaseService $service, CaseSearchRequest $request): JsonResponse
    {
        $response = $service->_list($request);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Get (
     *     path="/api/cases/{id}",
     *     tags={"Cases"},
     *     description="Get single case",
     *     @OA\Parameter(description="Case id", in="path", name="id", required=true, example=1, @OA\Schema(type="integer")),
     *     @OA\Response(
     *      response="200",
     *      description="Return category data",
     *      @OA\JsonContent(ref="#/components/schemas/CaseSearchResource")
     *     ),
     *     @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param $id
     * @param CaseService $caseService
     * @return JsonResponse
     * @throws Throwable
     */
    public function show($id, CaseService $caseService): JsonResponse
    {
        $response = $caseService->show($id);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Post(
     *     path="/api/cases",
     *     operationId="Cases Store",
     *     tags={"Cases"},
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/CaseRequest")
     *     ),
     *     @OA\Response(response="200", description="Return bool"),
     *     @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *     @OA\Response(response=500, description="INTERNAL_SERVER_ERROR"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param CaseRequest $request
     * @param CaseService $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(CaseRequest $request, CaseService $service): JsonResponse
    {
        $response = $service->create($request);
        return $this->successResponseWithData(new CaseResource($response));
    }

    /**
     * @OA\Put (
     *     path="/api/cases/{id}",
     *     tags={"Cases"},
     *     description="Update case",
     *     @OA\Parameter(description="Case id", in="path", name="id", required=true, example=1, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/CaseRequest")),
     *     @OA\Response(response="200", description="Cases sucsessfully updates", @OA\JsonContent(ref="#/components/schemas/CaseUpdateRequest")),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * Update case
     * @param BICase $case
     * @param CaseUpdateRequest $request
     * @param CaseService $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(BICase $case, CaseUpdateRequest $request, CaseService $service): JsonResponse
    {
        $response = $service->update($case, $request);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Delete (
     *     path="/api/cases/{id}",
     *     tags={"Cases"},
     *     description="Delete case",
     *     @OA\Parameter(description="Case id", in="path", name="id", required=true, example=1, @OA\Schema(type="integer")),
     *     @OA\Response(response="200",description="Case successfully deleted"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * Delete Case
     * @param BICase $case
     * @param CaseService $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(BICase $case, CaseService $service): JsonResponse
    {
        $service->delete($case);
        return $this->successResponse(Response::HTTP_OK);
    }

    /**
     * @OA\Put (
     *     path="/api/cases/restore/{id}",
     *     tags={"Cases"},
     *     description="Restore case",
     *     @OA\Parameter(description="Case id", in="path", name="id", required=true, example=1, @OA\Schema(type="integer")),
     *     @OA\Response(response="200", description="Cases sucsessfully restore"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param $id
     * @param CaseService $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function restore($id, CaseService $service): JsonResponse
    {
        $response = $service->restore($id);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\GET (
     *     path="/api/cases/guid/{guid}",
     *     tags={"Cases"},
     *     description="Get case by GUID",
     *     @OA\Parameter(description="Case GUID", in="path", name="guid", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response="200", description="Return case data", @OA\JsonContent(ref="#/components/schemas/CaseRequest")),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param string $guid
     * @param CaseService $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function getByGUID(string $guid, CaseService $service): JsonResponse
    {
        $response = $service->getByGuid($guid);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Post (
     *     path="/api/cases/init",
     *     tags={"Cases"},
     *     @OA\RequestBody(required=true ,@OA\JsonContent(ref="#/components/schemas/CaseInitRequest")),
     *     @OA\Response(response="200",description="Case successfully created", @OA\JsonContent(ref="#/components/schemas/CaseSearchResource")),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param CaseService $service
     * @param CaseInitRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function init(CaseService $service, CaseInitRequest $request): JsonResponse
    {
        $response = $service->init($request);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Post(
     *     path="/api/cases/check",
     *     operationId="Cases check",
     *     tags={"Cases"},
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/CaseRequest")
     *     ),
     *     @OA\Response(response="200",description="Case successfully check",
     *      @OA\JsonContent(ref="#/components/schemas/CaseCheckResource")
     *     ),
     *     @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *     @OA\Response(response=500, description="INTERNAL_SERVER_ERROR"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param CaseRequest $request
     * @param CaseService $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function check(CaseRequest $request, CaseService $service): JsonResponse
    {
        $response = $service->check($request);
        return $this->successResponseWithData(new CaseCheckResource($response));
    }
}
