<?php

namespace App\Http\Requests\Head;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationRequest extends FormRequest
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
            //
            "start_date" => ['required'],
            "end_date" => ['required'],
            // "rating" => ['required'],
            // "adjectival_rating" => ['required'],
        ];
    }

    public function messages()
    {
        return [
            "start_date.required" => "Required.",
            "end_date.required" => "Required.",
            // "rating.required" => "Required.",
            // "adjectival_rating.required" => "Required.",
        ];
    }
}
