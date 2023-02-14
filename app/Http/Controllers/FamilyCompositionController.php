<?php

namespace App\Http\Controllers;

use App\Http\Requests\FamilyCompositionRequest;
use App\Http\Requests\FamilyCompositionSearchRequest;
use App\Http\Resources\FamilyCompositionResource;
use App\Models\FamilyComposition;
use App\Services\FamilyCompositionService;
use Illuminate\Http\JsonResponse;
use Throwable;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Family Compositions",
 *     description="Family compositions Dict"
 * )
 */
class FamilyCompositionController extends ApiController
{

    /**
     * @OA\Get(
     *      path="/api/family-compositions",
     *      tags={"Family Compositions"},
     *      description="Get list of family compositions with search",
     *      @OA\Parameter(description="Search string",in="query",name="search",required=false,example="семейств", @OA\Schema(type="string")),
     *      @OA\Parameter(description="List limit",in="query",name="limit",required=false,example="12", @OA\Schema(type="integer")),
     *      @OA\Parameter(description="Offset",in="query",name="offset",required=false,example="0", @OA\Schema(type="integer")),
     *      @OA\Response(response="200",description="Return compositions list",@OA\JsonContent(ref="#/components/schemas/FamilyCompositionRequest"),
     *      ),
     *      @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     *
     * @param FamilyCompositionSearchRequest $request
     * @param FamilyCompositionService $service
     * @return JsonResponse
     */
    public function index(FamilyCompositionSearchRequest $request, FamilyCompositionService $service): JsonResponse
    {
        $response = $service->_list($request);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Get (
     *      path="/api/family-compositions/{id}",
     *      tags={"Family Compositions"},
     *      description="Get single family composition",
     *      @OA\Parameter(description="Composition id",in="path",name="id",required=true,example=1, @OA\Schema(type="integer")),
     *      @OA\Response(response="200",description="Return family composition data",@OA\JsonContent(ref="#/components/schemas/FamilyCompositionRequest"),
     *      ),
     *      @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *      security={
     *       {"bearerAuth": {}}
     *      }
     * )
     * @param FamilyComposition $composition
     * @param FamilyCompositionService $service
     * @return JsonResponse
     */
    public function show(FamilyComposition $composition, FamilyCompositionService $service): JsonResponse
    {
        $response = $service->show($composition);
        return $this->successResponseWithData(new FamilyCompositionResource($response));
    }

    /**
     * @OA\Post (
     *      path="/api/family-compositions",
     *      tags={"Family Compositions"},
     *      @OA\RequestBody(required=true,@OA\JsonContent(ref="#/components/schemas/FamilyCompositionRequest")),
     *      @OA\Response(response="200", description="Return bool"),
     *      @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *      security={
     *       {"bearerAuth": {}}
     *      }
     * )
     * @param FamilyCompositionRequest $request
     * @param FamilyCompositionService $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(FamilyCompositionRequest $request, FamilyCompositionService $service): JsonResponse
    {
        $response = $service->save(new FamilyComposition, $request);
        return $this->successResponseWithData(new FamilyCompositionResource($response));
    }

    /**
     * @OA\Put  (
     *      path="/api/family-compositions/{id}",
     *      tags={"Family Compositions"},
     *      description="Update family composition",
     *      @OA\Parameter(description="Composition id",in="path",name="id",required=true,example=1, @OA\Schema(type="integer")),
     *      @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/FamilyCompositionRequest"),
     *      ),
     *      @OA\Response(response="200",description="Return updated family composition"),
     *      @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     * )
     *
     * @param FamilyComposition $familyComposition
     * @param FamilyCompositionService $service
     * @param FamilyCompositionRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(FamilyComposition $familyComposition, FamilyCompositionService $service, FamilyCompositionRequest $request): JsonResponse
    {
        $response = $service->save($familyComposition, $request);
        return $this->successResponseWithData(new FamilyCompositionResource($response));
    }

    /**
     * @OA\Delete  (
     *      path="/api/family-compositions/{id}",
     *      tags={"Family Compositions"},
     *      description="Delete family composition",
     *      @OA\Parameter(description="Composition id",in="path",name="id",required=true,example=1, @OA\Schema(type="integer")),
     *      @OA\Response(response="200",description="Family composition Successfully deleted"),
     *      @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *      security={
     *       {"bearerAuth": {}}
     *      }
     *  )
     *
     * @param FamilyComposition $familyComposition
     * @param FamilyCompositionService $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(FamilyComposition $familyComposition, FamilyCompositionService $service): JsonResponse
    {
        $service->delete($familyComposition);
        return $this->successResponse(Response::HTTP_OK);
    }
}
