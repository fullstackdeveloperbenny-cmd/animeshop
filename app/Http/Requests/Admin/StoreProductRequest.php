<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Product::class);
    }

    public function rules(): array
    {
        return [
            // Hoofd product info
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'badge' => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            
            // Varianten
            'variants' => ['nullable', 'array'],
            'variants.*.type' => ['required_with:variants', 'string', 'max:50'],
            'variants.*.value' => ['required_with:variants', 'string', 'max:50'],
            'variants.*.stock' => ['nullable', 'integer', 'min:0'],
            'variants.*.price_modifier' => ['nullable', 'numeric'],

            // Afbeeldingen (meerdere mogelijk)
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
