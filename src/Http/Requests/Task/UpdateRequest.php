<?php

namespace Geeksesi\TodoLover\Http\Requests\Task;

use Geeksesi\TodoLover\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && $this->task->owner->id === Auth::user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => "string",
            "description" => "string",
            "status" => ["numeric", "in:" . implode(",", TaskStatusEnum::ALL)],
            "labels" => "array",
            "labels.*" => "string",
        ];
    }
}
