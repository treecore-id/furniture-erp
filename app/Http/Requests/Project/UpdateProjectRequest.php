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
            'name' => 'required|string|max:255',
            'client' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1024',
            'project_value' => 'nullable|numeric',
            'date_start' => 'required|date',
            'date_deadline' => 'required|date',
            'date_end' => 'nullable|date',
        ];
    }
}
