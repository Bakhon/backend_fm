<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Throwable;

/**
 * @OA\Schema(
 *      title="Case request",
 *      description="Case request body data",
 *      type="object",
 *      required={"name"}
 * )
 * @OA\Property(property="CaseName", type="string", example="(Dr)_ Door78_Дверь Двустворчатая_Внутренняя_ГОСТ 31173"),
 * @OA\Property(property="CaseHashAfter", type="string", example="a35bc872-1910-11eb-950d-00155d34d6e2"),
 * @OA\Property(property="CaseHashBefore", type="string", example="a35bc872-1910-11eb-950d-00155d34d6e2"),
 * @OA\Property(property="CategoryID", type="integer", example=9),
 * @OA\Property(property="SectionID", type="integer", example=1),
 * @OA\Property(property="Files", type="array",
 *     @OA\Items(type="object", format="query", ref="#/components/schemas/CaseFileRequest"),
 * ),
 *
 * @property string $CaseName
 * @property string $CaseHashAfter
 * @property string $CaseHashBefore
 * @property int $CategoryID
 * @property int $SectionID
 * @property RegDataRequest $RegData
 * @property CaseFileRequest[] $Files
 */
class CaseRequest extends Request
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
     * @throws Throwable
     */
    public function rules()
    {
        if ($this->Files) {
            $files = [];

            foreach ($this->Files as $file) {
                $validator = Validator::make($file, (new CaseFileRequest)->rules());

                if ($validator->fails()) {
                    throw new ApiException($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
                }
                $files[] = new CaseFileRequest($file);
            }
            $this->Files = $files;
        }

        $this->CaseHashBefore = strtoupper($this->CaseHashBefore);
        if ($this->CaseHashAfter) {
            $this->CaseHashAfter = strtoupper($this->CaseHashAfter);
        }

        return [
            'CaseName' => 'required|string',
            'CaseHashAfter' => 'nullable|string',
            'CaseHashBefore' => 'required|string',
            'Files' => 'nullable|array',
            'CategoryID' => 'required|integer|exists:categories,id',
            'SectionID' => 'required|integer|exists:sections,id',
        ];
    }
}
