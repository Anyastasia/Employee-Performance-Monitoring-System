<?php

namespace App\Http\Requests\Head;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            "current_password" => ['required', 'current_password:head'],
            "password" => ['required', 'confirmed'],
            'password_confirmation' => ['required',]
        ];
    }

    public function messages()
    {
        return [
            "current_password.required" => "Required.",
            "current_password.current_password" => "Please enter your current password.",
            "password.required" => 'Required.',
            "password_confirmation.required" => 'Required.',
            "password.confirmed" => "Passwords do not match.",
        ];
    }
}
