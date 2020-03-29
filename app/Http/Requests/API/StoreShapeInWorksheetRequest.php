<?php

namespace App\Http\Requests\API;

use App\Http\Services\ShapeService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShapeInWorksheetRequest extends FormRequest
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
     * @param ShapeService $shapeService
     *
     * @return array
     */
    public function rules(ShapeService $shapeService)
    {
        return [
            'id' => [ 'required', 'integer' ],
            'type' => [ 'required', Rule::in($shapeService->getAvailableShapeKeys()) ],
            'x' => [ 'required', 'numeric' ],
            'y' => [ 'required', 'numeric' ]
        ];
    }
}
