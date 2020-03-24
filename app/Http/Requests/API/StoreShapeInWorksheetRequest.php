<?php

namespace App\Http\Requests\API;

use App\Models\Shapes\Circle;
use App\Models\User;
use App\Models\Worksheet;
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
     * @return array
     */
    public function rules()
    {
        return [
            'id' => [ 'required', 'integer' ],
            'type' => [ 'required', Rule::in(array_keys(config('shapes.list'))) ],
            'x' => [ 'required', 'numeric' ],
            'y' => [ 'required', 'numeric' ]
        ];
    }
}
