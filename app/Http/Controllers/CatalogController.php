<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatalogCategoryRequest;
use App\Http\Requests\CatalogLinkRequest;
use App\Services\CatalogService;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Exception;

/**
 * @OA\Tag(
 *     name="Catalog",
 *     description="Catalog relations"
 * )
 */
class CatalogController extends ApiController
{
    /**
     * @OA\Post (
     *      path="/api/calalog/link",
     *      tags={"Catalog"},
     *      @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/CatalogLinkRequest")),
     *      @OA\Response(response="200", description="Return bool"),
     *      @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *      security={
     *       {"bearerAuth": {}}
     *      }
     * )
     * @param CatalogLinkRequest $request
     * @param CategoryService $categoryService
     * @return JsonResponse
     * @throws Exception
     */
    public function link(CatalogLinkRequest $request, CategoryService $categoryService): JsonResponse
    {
        $categoryService->link($request);
        return $this->successResponse(Response::HTTP_OK);
    }

    /**
     * @OA\Get (
     *     path="/api/catalog/tree",
     *     tags={"Catalog"},
     *     description="Get catalog tree",
     *     @OA\Response(response="200", description="Return catalog list",
     *      @OA\JsonContent(type="array",
     *       @OA\Items(
     *           @OA\Property(property="section", type="object", ref="#/components/schemas/SectionRequest"),
     *           @OA\Property(property="categories", type="object", ref="#/components/schemas/CategoryRequest"),
     *       )
     *      ),
     *     ),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param CategoryService $categoryService
     * @return JsonResponse
     */
    public function getTree(CategoryService $categoryService): JsonResponse
    {
        $response = $categoryService->getTree();
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Get (
     *     path="/api/catalog/categories",
     *     tags={"Catalog"},
     *     description="Get catalog categories",
     *     @OA\Parameter(in="query", name="search", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(description="List limit", in="query", name="limit", required=false, example=10, @OA\Schema(type="integer")),
     *     @OA\Parameter(description="Offset", in="query", name="offset", required=false, example=0, @OA\Schema(type="integer")),
     *     @OA\Response(response="200", description="Return catalog list",
     *      @OA\JsonContent(type="array",
     *       @OA\Items(
     *          @OA\Property(property="category", type="object", ref="#/components/schemas/CategoryRequest"),
     *          @OA\Property(property="section", type="object", ref="#/components/schemas/SectionRequest"),
     *       )
     *      ),
     *     ),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param CatalogService $catalogService
     * @param CatalogCategoryRequest $request
     * @return JsonResponse
     */
    public function categories(CatalogService $catalogService, CatalogCategoryRequest $request): JsonResponse
    {
        $response = $catalogService->sectionCategories($request);
        return $this->successResponseWithData($response);
    }
}
