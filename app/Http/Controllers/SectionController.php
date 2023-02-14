<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Http\Requests\SectionSearchRequest;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use App\Services\SectionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

/**
 * @OA\Tag(
 *     name="Sections",
 *     description="Catalog sections"
 * )
 */
class SectionController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/api/sections",
     *     tags={"Sections"},
     *     description="Get list of sections with search",
     *     @OA\Parameter(description="Search string",in="query",name="search",required=false,example="section", @OA\Schema(type="string")),
     *     @OA\Parameter(description="List limit",in="query",name="limit",required=false,example="12", @OA\Schema(type="integer")),
     *     @OA\Parameter(description="Offset",in="query",name="offset",required=false,example="0", @OA\Schema(type="integer")),
     *     @OA\Response(response="200",description="Return sections list",@OA\JsonContent(ref="#/components/schemas/SectionRequest")),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     },
     * )
     * @param SectionSearchRequest $request
     * @param SectionService $sectionService
     * @return JsonResponse
     */
    public function index(SectionSearchRequest $request, SectionService $sectionService): JsonResponse
    {
        $response = $sectionService->_list($request);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Post (
     *     path="/api/sections",
     *     tags={"Sections"},
     *     description="Create section",
     *     @OA\RequestBody(required=true,@OA\JsonContent(ref="#/components/schemas/SectionRequest")),
     *     @OA\Response(response="200",description="Section successfully created"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param SectionRequest $request
     * @param SectionService $sectionService
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(SectionRequest $request, SectionService $sectionService): JsonResponse
    {
        $section = new Section();
        $response = $sectionService->save($section, $request);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Get (
     *     path="/api/sections/{id}",
     *     tags={"Sections"},
     *     description="Get single section",
     *     @OA\Parameter(description="Section id",in="path",name="id",required=true,example=1, @OA\Schema(type="integer")),
     *     @OA\Response(response="200",description="Return section data",@OA\JsonContent(ref="#/components/schemas/SectionRequest")),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param Section $section
     * @param SectionService $sectionService
     * @return JsonResponse
     */
    public function show(Section $section, SectionService $sectionService): JsonResponse
    {
        $response = $sectionService->show($section);
        return $this->successResponseWithData(new SectionResource($response));
    }


    /**
     * @OA\Put  (
     *     path="/api/sections/{id}",
     *     tags={"Sections"},
     *     description="Update section",@OA\Parameter(description="Section id",in="path",name="id",required=true,example=1, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true,@OA\JsonContent(ref="#/components/schemas/SectionRequest")),
     *     @OA\Response(response="200",description="Return updated section"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param Section $section
     * @param SectionRequest $request
     * @param SectionService $sectionService
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(Section $section, SectionRequest $request, SectionService $sectionService): JsonResponse
    {
        $response = $sectionService->save($section, $request);
        return $this->successResponseWithData(new SectionResource($response));
    }

    /**
     * @OA\Delete  (
     *     path="/api/sections/{id}",
     *     tags={"Sections"},
     *     description="Delete section",
     *     @OA\Parameter(description="Section id",in="path",name="id",required=true,example=1, @OA\Schema(type="integer")),
     *     @OA\Response(response="200",description="Section successfully deleted"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param Section $section
     * @param SectionService $sectionService
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(Section $section, SectionService $sectionService): JsonResponse
    {
        $sectionService->delete($section);
        return $this->successResponse(Response::HTTP_OK);
    }

    /**
     * @OA\Get (
     *     path="/api/sections/{id}/categories",
     *     tags={"Sections"},
     *      description="Get single section with related categories",
     *      @OA\Parameter(description="Section id",in="path",name="id",required=true,example=1, @OA\Schema(type="integer")),
     *
     *
     * @OA\Response(
     *     response="200",
     *     description="Return section data",
     *      @OA\JsonContent(
     *          @OA\Property (property="section",type="array", @OA\Items(
     *              @OA\Property (property="creator_id",type="integer",example=5,description="user id"),
     *              @OA\Property (property="name",type="string",example="Конструкции железобетонные",description="Full section name"),
     *              @OA\Property (property="short_name",type="string",example="КЖ",description="Short section name"),
     *              @OA\Property (property="parent_id",type="integer",example=1, default=null,description="Parent section_id"),
     *              @OA\Property (property="order",type="integer",example=0,default=0,description="Order index"),
     *                  ),
     *              ),
     *          @OA\Property (property="categories",type="array", @OA\Items(
     *              @OA\Property (property="creator_id",type="integer",example=5,description="user id"),
     *              @OA\Property (property="full_name",type="string",example="Арматура",description="Full section name"),
     *              @OA\Property (property="name",type="string",example="Арматура",description="Section name"),
     *              @OA\Property (property="version",type="integer",example="2",description="Version"),
     *              @OA\Property (property="parent_id",type="integer",example=null, default=null,description="Parent category id"),
     *              @OA\Property (property="system",type="integer",example=null,default=null),
     *              @OA\Property (property="key",type="integer",example=null,default=null),
     *              @OA\Property (property="_ltr",type="integer",example=0,default=0,description="Left tree index"),
     *              @OA\Property (property="_rgt",type="integer",example=0,default=0,description="Right tree index"),
     *                  ),
     *              ),
     *          ),
     *      ),
     *
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param int $id
     * @param SectionService $sectionService
     * @return JsonResponse
     */
    public function withCategories(int $id, SectionService $sectionService): JsonResponse
    {
        $response = $sectionService->withCategories($id);
        return $this->successResponseWithData($response);
    }
}
