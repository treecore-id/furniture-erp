<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            // Product
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'product_code' => 'nullable|string|max:100',
            'unit_price' => 'nullable|numeric',
            // Product Attribute
            'attributes' => 'nullable|array',
            'attributes.*.name' => 'required_with:attributes|string|max:50',
            'attributes.*.value' => 'required_with:attributes|string|max:100',
            // Product Image
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_image_index' => ['required', 'integer', 'min:0', 'max:' . (count($this->images ?? []) - 1)],
        ];
    }

    // Get the error messages for the defined validation rules.
    public function messages(): array
    {
        return [
            // Product
            'category_id.required' => 'category_id is required',
            'category_id.exists' => 'category_id is not exist',
            'name.required' => 'name is required',
            'name.max' => 'maximum value 100 characters',
            'description.max' => 'maximum value 1000 characters',
            'product_code.max' => 'maximum value 100 characters',
            // Product Attribute
            'attributes.*.name.max' => 'maximum value 50 characters',
            'attributes.*.value.max' => 'maximum value 100 characters',
            // Product Image
            'images.required' => 'image is required, minimum 1 image',
            'images.min' => 'minimum 1 image',
            'images.max' => 'maximum 5 image',
            'images.mimes' => 'Accepted image formats are jpg, jpeg, png and gif',
            'images.*.max' => 'maximum image size is 2 MB',
        ];
    }
}
