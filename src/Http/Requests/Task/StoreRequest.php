<?php

namespace Geeksesi\TodoLover\Http\Requests\Task;

use Geeksesi\TodoLover\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => "required|string",
            "description" => "required|string",
            "labels" => "array",
            "labels.*" => "string",
        ];
    }
}
