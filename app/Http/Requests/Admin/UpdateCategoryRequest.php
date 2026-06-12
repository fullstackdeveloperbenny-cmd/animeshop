<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Bepaal of de gebruiker bevoegd is voor dit verzoek.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('category'));
    }

    /**
     * Haal de validatieregels op die gelden voor het verzoek.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            // De slug moet uniek zijn, behalve voor de huidige categorie
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug,' . $this->route('category')->id],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
