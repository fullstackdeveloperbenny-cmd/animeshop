<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'badge' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'primary_image_index' => 'nullable|integer',
            
            'variants' => 'nullable|array',
            'variants.*.type' => 'required_with:variants|string|max:50',
            'variants.*.value' => 'nullable|string|max:255',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.price_modifier' => 'nullable|numeric',
        ];
    }
}
