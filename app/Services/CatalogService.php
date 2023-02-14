<?php

namespace App\Services;

use App\Http\Requests\CatalogCategoryRequest;
use App\Http\Resources\SectionCategoryResource;
use App\Models\SectionCategory;

/**
 * Class CatalogService
 * @package App\Services
 */
class CatalogService extends Service
{

    /**
     * @param CatalogCategoryRequest $request
     * @return array
     */
    public function sectionCategories(CatalogCategoryRequest $request): array
    {
        $query = SectionCategory::leftJoin('categories', 'categories.id', '=', 'section_category.category_id')
            ->select('section_category.*')
            ->orderBy('categories.name');
        $query->with(['section', 'category']);

        $queryCount = $query->count();

        $query->limit($request->limit)->offset($request->offset);

        return [
            'list' => SectionCategoryResource::collection($query->get()),
            'listCount' => $queryCount,
        ];
    }
}
