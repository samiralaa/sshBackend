<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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
            'name.en' => 'required|string|max:255',
            'name.ar' => 'required|string|max:255',
            'description.en' => 'required|string',
            'description.ar' => 'required|string',
            'company.en' => 'required|string|max:255',
            'company.ar' => 'required|string|max:255',
            'location.en' => 'required|string|max:255',
            'location.ar' => 'required|string|max:255',
            'status' => 'required|string|in:Active,Inactive',
            'type' => 'required|string|max:255',
            'link' => 'required|url',
        ];
    }
}
