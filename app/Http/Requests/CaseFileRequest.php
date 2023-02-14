<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *      title="CaseFile request",
 *      description="CaseFile request body data",
 *      type="object",
 *      required={"name"}
 * )
 * @OA\Property(property="Name", type="string", example="BG1_Анкер_с проушиной.rfa"),
 * @OA\Property(property="Hash", type="string", example="C6EB405CF7D2659DA2F6011B8AD04CB90F8F49A4E39E711DC60A35A2820BEC61"),
 * @OA\Property(property="HashAfter", type="string", example="C6EB405CF7D2659DA2F6011B8AD04CB90F8F49A4E39E711DC60A35A2820BEC61"),
 * @OA\Property(property="CaseItemTypeId", type="integer", example=1),
 * @OA\Property(property="MetaData", type="string"),
 *
 * @property string $Name
 * @property string $Hash
 * @property string $HashAfter
 * @property string $MetaData
 * @property int $CaseItemTypeId
 */
class CaseFileRequest extends Request
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
     */
    public function rules()
    {

        $this->Hash = strtoupper($this->Hash);
        if ($this->HashAfter) {
            $this->HashAfter = strtoupper($this->HashAfter);
        }

        return [
            'Name' => 'required|string',
            'Hash' => 'required|string',
            'HashAfter' => 'nullable|string',
            'CaseItemTypeId' => 'required|integer|exists:family_compositions,id',
        ];
    }
}
