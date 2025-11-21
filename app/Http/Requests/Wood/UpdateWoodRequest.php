<?php

namespace App\Http\Requests\Wood;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWoodRequest extends FormRequest
{
    /* Determine if the user is authorized to make this request. */
    public function authorize(): bool
    {
        return true;
    }

    /* Get the validation rules that apply to the request. */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
        ];
    }

    // Get the error messages for the defined validation rules.
    public function messages(): array
    {
        return [
            'name.required' => 'name is required',
            'name.max' => 'maximum value 50 characters',
            'description.max' => 'maximum value 1000 characters',
        ];
    }
}
