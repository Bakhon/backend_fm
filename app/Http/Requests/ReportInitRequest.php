<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Schema(
 *      title="ReportInit request",
 *      description="ReportInit request body data",
 *      type="object",
 *      required={"name"}
 * )
 * @OA\Property(property="project", type="string", example="RME_basic_sample_project"),
 * @OA\Property(property="families", type="array",
 *     @OA\Items(type="object", format="query", ref="#/components/schemas/FamilyRequest"),
 * ),
 *
 * @property string $project
 * @property FamilyRequest[] $families
 */
class ReportInitRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws ApiException
     */
    public function rules()
    {
        $families = [];

        if ($this->families) {
            /** @var array $family */
            foreach ($this->families as $family) {
                $validator = Validator::make($family, (new FamilyRequest)->rules());

                if ($validator->fails()) {
                    throw new ApiException($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
                }
                $families[] = new FamilyRequest($family);
            }

            $this->families = $families;
        }

        return [
            'project' => 'required|string',
            'families' => 'required',
        ];
    }
}
