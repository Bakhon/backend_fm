<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Http\Requests\CatalogLinkRequest;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategorySearchRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Section;
use App\Models\SectionCategory;
use App\Reference\Constants;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class CategoryService
 * @package App\Services
 */
class CategoryService extends Service
{
    /**
     * @param CategorySearchRequest $request
     * @return array
     */
    public function _list(CategorySearchRequest $request): array
    {
        $query = Category::where([]);

        if ($request->search) {
            $query->where('name', 'ilike', '%' . $request->search . '%');
        }

        $queryWithoutLimit = clone $query;

        $query->limit($request->limit);
        $query->offset($request->offset);

        $query->orderBy('name');

        $query->with(['sections']);
        $categories = CategoryResource::collection($query->get());

        return [
            'list' => $categories,
            'listCount' => $queryWithoutLimit->count(),
        ];
    }

    /**
     * Create/Update Category
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @return Category
     * @throws Exception
     */
    public function save(CategoryRequest $request, Category $category): Category
    {
        try {
            DB::beginTransaction();

            $category->name = $request->name;
            $category->full_name = $request->full_name;

            if (!$category->save()) {
                $this->exceptionResponse(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_BAD_REQUEST);
            }

            $category->sections()->sync($request->section_ids);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new ApiException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $category->load(['sections']);
        return $category;
    }

    /**
     * Get single category
     *
     * @param Category $category
     * @return Category
     */
    public function show(Category $category): Category
    {
        $category->load(['sections']);
        return $category;
    }

    /**
     * Delete category
     *
     * @param Category $category
     * @return bool
     * @throws Exception
     */
    public function delete(Category $category): bool
    {
        if (!$category->delete()) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return true;
    }

    /**
     * Create SectionCategory model
     *
     * @param CatalogLinkRequest $request
     * @return bool
     * @throws ApiException
     */
    public function link(CatalogLinkRequest $request): bool
    {
        $link = SectionCategory::where([
            'section_id' => $request->section_id,
            'category_id', $request->category_id
        ])->first();

        if (!$link) {
            throw new ApiException(Constants::CATALOG_LINK_EXISTS, Response::HTTP_BAD_REQUEST);
        }

        SectionCategory::create([
            'section_id' => $request->section_id,
            'category_id' => $request->category_id
        ]);

        return true;
    }

    /**
     * @return array
     */
    public function getTree(): array
    {
        return Section::with('category')->get()->toArray();
    }
}
