<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'product_code' => 'nullable|string|max:100',
            'unit_price' => 'nullable|numeric',
        ];
    }

    // Get the error messages for the defined validation rules.
    public function messages(): array
    {
        return [
            'category_id.required' => 'category_id is required',
            'name.required' => 'name is required',
            'name.max' => 'maximum value 100 characters',
            'description.max' => 'maximum value 1000 characters',
            'product_code.max' => 'maximum value 100 characters',
        ];
    }
}
