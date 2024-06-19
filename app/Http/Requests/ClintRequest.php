<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClintRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'code' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8', // Use 'sometimes' if the password should only be required on create
            'email' => 'required|string|email|max:255|unique:clints,email,' . $this->route('clint'),
        ];
    }
}
