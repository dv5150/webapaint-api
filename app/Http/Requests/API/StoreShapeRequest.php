<?php

namespace App\Http\Requests\API;

use App\Http\Services\ShapeService;
use App\Models\Color;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShapeRequest extends FormRequest
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
        $colors = Color::query()
                       ->pluck('id')
                       ->toArray();

        return [
            'type' => [ 'required', Rule::in($shapeService->getAvailableShapeKeys()) ],
            'color_id' => [ 'required', 'integer', Rule::in($colors) ],
            'radius' => 'required_if:type,circle|numeric',
            'height' => 'required_if:type,rectangle|numeric',
            'width' => 'required_if:type,rectangle|numeric'
        ];
    }
}
