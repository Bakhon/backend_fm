<?php

namespace App\Http\Requests;


/**
 * @OA\Schema(
 *      title="Section request",
 *      description="Section request body data",
 *      type="object",
 *      required={"name","short_name","order"}
 * )
 *
 * @OA\Property (property="name", type="string",example="Фасады")
 * @OA\Property (property="short_name", type="string",example="ФС")
 * @OA\Property (property="order", type="integer",example=4)
 * @OA\Property (property="parent_id", type="integer",example=null)
 * @OA\Property (property="creator_id", type="integer",example=null)
 *
 * @property string name
 * @property string short_name
 * @property integer parent_id
 * @property integer order
 * @property integer creator_id
 * @property integer id
 */
class SectionRequest extends Request
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
        return [
            'creator_id' => 'nullable|integer',
            'name' => 'required|string',
            'short_name' => 'required|string',
            'parent_id' => 'nullable|integer',
            'order' => 'required|integer',
        ];
    }
}
