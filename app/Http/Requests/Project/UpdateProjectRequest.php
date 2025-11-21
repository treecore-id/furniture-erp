<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'client' => 'required|string|max:50',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'project_value' => 'nullable|numeric',
            'date_start' => 'required|date',
            'date_deadline' => 'required|date',
            'date_end' => 'nullable|date',
        ];
    }

    // Get the error messages for the defined validation rules.
    public function messages(): array
    {
        return [
            'name.required' => 'name is required',
            'name.max' => 'maximum value 50 characters',
            'client.required' => 'client is required',
            'client.max' => 'maximum value 50 characters',
            'address.max' => 'maximum value 255 characters',
            'description.max' => 'maximum value 1000 characters',
            'date_start.required' => 'date start is required',
            'date_deadline.required' => 'target date is required',
        ];
    }
}
