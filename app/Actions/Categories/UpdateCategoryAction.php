<?php

namespace App\Actions\Categories;

use App\Models\Category;
use Illuminate\Support\Str;

class UpdateCategoryAction
{
    /**
     * Werk een bestaande categorie bij.
     */
    public function handle(Category $category, array $data): Category
    {
        // Als de naam is veranderd en er is geen nieuwe slug meegestuurd, update de slug
        if (empty($data['slug']) && isset($data['name']) && $data['name'] !== $category->name) {
            $data['slug'] = Str::slug($data['name']);
        } elseif (empty($data['slug'])) {
            // Voorkom dat de slug per ongeluk leeggemaakt wordt
            unset($data['slug']); 
        }

        // is_active checkbox afhandeling (HTML forms sturen geen unchecked checkboxes mee)
        if (array_key_exists('is_active', $data)) {
            $data['is_active'] = (bool) $data['is_active'];
        } else {
            $data['is_active'] = false; 
        }

        $category->update($data);

        return $category;
    }
}
