<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategorySearchRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

/**
 * @OA\Tag(
 *     name="Categories",
 *     description="Catalog categories"
 * )
 */
class CategoryController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     tags={"Categories"},
     *     description="Get list of categories with search",
     *     @OA\Parameter(description="Search query", in="query", name="search", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(description="List limit", in="query", name="limit", required=false, example="10", @OA\Schema(type="integer")),
     *     @OA\Parameter(description="Offset", in="query", name="offset", required=false, example="0", @OA\Schema(type="integer")),
     *     @OA\Response(response="200", description="Return categories list", @OA\JsonContent(ref="#/components/schemas/CategoryRequest")),
     *     @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     * @param CategorySearchRequest $request
     * @param CategoryService $categoryService
     * @return JsonResponse
     */
    public function index(CategorySearchRequest $request, CategoryService $categoryService): JsonResponse
    {
        $response = $categoryService->_list($request);
        return $this->successResponseWithData($response);
    }

    /**
     * @OA\Post (
     *     path="/api/categories",
     *     tags={"Categories"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/CategoryRequest")),
     *     @OA\Response(response="200", description="Category successfully created"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     *
     * @param CategoryRequest $request
     * @param CategoryService $categoryService
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(CategoryRequest $request, CategoryService $categoryService): JsonResponse
    {
        $response = $categoryService->save($request, new Category());
        return $this->successResponseWithData(new CategoryResource($response));
    }


    /**
     * @OA\Get (
     *     path="/api/categories/{id}",
     *     tags={"Categories"},
     *     description="Get single category",
     *     @OA\Parameter(description="Category id", in="path", name="id", required=true, example=1, @OA\Schema(type="integer")),
     *     @OA\Response(response="200",description="Return category data",@OA\JsonContent(ref="#/components/schemas/CategoryRequest")),
     *     @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     *
     * @param Category $category
     * @param CategoryService $categoryService
     * @return JsonResponse
     */
    public function show(Category $category, CategoryService $categoryService): JsonResponse
    {
        $response = $categoryService->show($category);
        return $this->successResponseWithData(new CategoryResource($response));
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     tags={"Categories"},
     *     description="Update category",
     *     @OA\Parameter(description="Category id",in="path",name="id",required=true,example=1, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true,@OA\JsonContent(ref="#/components/schemas/CategoryRequest")),
     *     @OA\Response(response="200",description="Category sucsessfully updated"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     *
     * @param Category $category
     * @param CategoryRequest $request
     * @param CategoryService $categoryService
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(Category $category, CategoryRequest $request, CategoryService $categoryService): JsonResponse
    {
        $categoryService->save($request, $category);
        return $this->successResponse(Response::HTTP_OK);
    }


    /**
     * @OA\Delete  (
     *     path="/api/categories/{id}",
     *     tags={"Categories"},
     *     description="Delete category",
     *     @OA\Parameter(description="Category id",in="path",name="id",required=true,example=1, @OA\Schema(type="integer")),
     *     @OA\Response(response="200",description="Category successfully deleted"),
     *     @OA\Response(response="403", description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     *
     * @param Category $category
     * @param CategoryService $categoryService
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(Category $category, CategoryService $categoryService): JsonResponse
    {
        $categoryService->delete($category);
        return $this->successResponse(Response::HTTP_OK);
    }
}
