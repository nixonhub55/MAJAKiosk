<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8|confirmed',
            'newPassword2' => 'required',
        ];
    }


    // public function authorize() {
    //     return true; // Set to true if the user is authorized to make this request
    // }
}
