<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Http\Requests\FamilyCompositionRequest;
use App\Http\Requests\FamilyCompositionSearchRequest;
use App\Http\Resources\FamilyCompositionResource;
use App\Models\FamilyComposition;
use App\Reference\CaseConstants;
use App\Reference\Constants;
use Illuminate\Http\Response;
use Exception;

/**
 * Class FamilyCompositionService
 * @package App\Services
 */
class FamilyCompositionService extends Service
{
    /**
     * Get list composition with search
     * @param FamilyCompositionSearchRequest $request
     * @return array
     */
    public function _list(FamilyCompositionSearchRequest $request)
    {
        $query = FamilyComposition::where([]);

        if ($request->search) {
            $query->where(function ($query) use ($request) {
                $query->orWhere('item_name', 'ilike', '%' . $request->search . '%')
                    ->orWhere('description', 'ilike', '%' . $request->search . '%');
            });
        }

        $queryWithoutLimit = clone $query;

        $query->limit($request->limit);
        $query->offset($request->offset);

        return [
            'list' => FamilyCompositionResource::collection($query->get()),
            'listCount' => $queryWithoutLimit->count(),
        ];
    }

    /**
     * Show single composition
     * @param FamilyComposition $composition
     * @return mixed
     */
    public function show(FamilyComposition $composition)
    {
        return $composition;
    }

    /**
     * Create / update composition
     *
     * @param FamilyComposition $composition
     * @param FamilyCompositionRequest $request
     * @return FamilyComposition
     * @throws ApiException
     */
    public function save(FamilyComposition $composition, FamilyCompositionRequest $request)
    {
        $composition->item_name = $request->item_name;
        $composition->description = $request->description;
        $composition->extension = $request->extension;
        $composition->template = $request->template;
        $composition->required = $request->required;

        if (!$composition->save()) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $composition;
    }

    /**
     * Delete Composition
     * @param FamilyComposition $composition
     * @throws \Exception
     */
    public function delete(FamilyComposition $composition)
    {
        if (!$composition->delete()) {
            throw new ApiException(Constants::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get FamilyComposition by extension
     *
     * @param string $extension
     * @param string $fileName
     * @return FamilyComposition
     * @throws Exception
     */
    public function getFamilyCompositionByExtension(string $extension, string $fileName): FamilyComposition
    {
        $familyCompositions = FamilyComposition::where(['extension' => $extension])->select('template')->get();

        $templates = [];

        /** @var FamilyComposition $familyComposition */
        foreach ($familyCompositions as $familyComposition) {
            $templates[] = $familyComposition->template;
        }

        usort($templates, function ($a, $b) {
            return strlen($b) <=> strlen($a);
        });

        $template = null;

        foreach ($templates as $item) {
            if (strpos($fileName, $item)) {
                $template = $item;
                break;
            }
        }

        /** @var FamilyComposition $familyComposition */
        $familyComposition = FamilyComposition::where(['template' => $template])->first();

        if (!$familyComposition) {
            throw new ApiException(CaseConstants::ERROR_FAMILY_COMPOSITION_NOT_FOUND, Response::HTTP_BAD_REQUEST);
        }

        return $familyComposition;
    }
}
