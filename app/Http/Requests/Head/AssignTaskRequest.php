<?php

namespace App\Http\Requests\Head;

use Illuminate\Foundation\Http\FormRequest;

class AssignTaskRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "task_title" => ['required'],
            "submission_start_date" => ['required'],
            "submission_due_date" => ['required'],
        ];
    }

    public function messages()
    {
        return [
            "task_title.required" => 'Required',
            "submission_start_date.required" => 'Required',
            "submission_due_date.required" => 'Required',
        ];
    }
}
