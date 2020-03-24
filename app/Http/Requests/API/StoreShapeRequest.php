<?php

namespace App\Http\Requests\API;

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
     * @return array
     */
    public function rules()
    {
        $colors = Color::query()->pluck('id')->toArray();

        return [
            'type' => [ 'required', Rule::in(array_keys(config('shapes.list'))) ],
            'color_id' => [ 'required', 'integer', Rule::in($colors) ],
            'radius' => 'required_if:type,circle|numeric',
            'height' => 'required_if:type,rectangle|numeric',
            'width' => 'required_if:type,rectangle|numeric'
        ];
    }
}
