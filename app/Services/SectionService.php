<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Http\Requests\SectionRequest;
use App\Http\Requests\SectionSearchRequest;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use App\Reference\Constants;
use Illuminate\Http\Response;
use Exception;

/**
 * Class SectionService
 * @package App\Services
 */
class SectionService extends Service
{
    /**
     * Get sections with relations by filter
     *
     * @param SectionSearchRequest $request
     * @return array
     */
    public function _list(SectionSearchRequest $request): array
    {
        $query = Section::where([]);

        if ($request->search) {
            $query->where(function ($query) use ($request) {
                $query->orWhere('name', 'ilike', '%' . $request->search . '%')
                    ->orWhere('short_name', 'ilike', '%' . $request->search . '%');
            });
        }

        $queryWithoutLimit = clone $query;

        $query->limit($request->limit);
        $query->offset($request->offset);

        $query->orderBy('name');

        return [
            'list' => SectionResource::collection($query->get()),
            'listCount' => $queryWithoutLimit->count(),
        ];
    }

    /**
     * Add section
     *
     * @param SectionRequest $request
     * @return bool
     * @throws Exception
     */
    public function create(SectionRequest $request): bool
    {
        $query = Section::where(['name' => $request->name]);

        if (!empty($request->parent_id)) {
            $query->where('parent_id', $request->parent_id);
        }

        if ($query->count() > 0) {
            $this->exceptionResponse(Constants::SECTION_EXISTS, Response::HTTP_BAD_REQUEST);
        }

        if (!Section::create($request->validated())) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return true;
    }

    /**
     * Show section
     *
     * @param Section $section
     * @return Section
     */
    public function show(Section $section): Section
    {
        return $section;
    }

    /**
     * Update section
     *
     * @param Section $section
     * @param SectionRequest $request
     * @return Section
     * @throws Exception
     */
    public function save(Section $section, SectionRequest $request): Section
    {
        $section->name = $request->name;
        $section->short_name = $request->short_name;
        $section->order = $request->order;

        if (!$section->save()) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $section;
    }

    /**
     * Delete section
     *
     * @param Section $section
     * @return bool
     * @throws Exception
     */
    public function delete(Section $section): bool
    {
        if (!$section->delete()) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return true;
    }

    /**
     * Get section with categories
     *
     * @param int $id
     * @return array
     */
    public function withCategories(int $id): array
    {
        $section = Section::find($id);
        $data = [];
        $data['section'] = $section->toArray();

        foreach ($section->category()->get() as $category) {
            $data['categories'][] = $category->toArray();
        }

        return $data;
    }
}
