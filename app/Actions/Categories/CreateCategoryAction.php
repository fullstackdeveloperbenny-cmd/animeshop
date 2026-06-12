<?php

namespace App\Actions\Categories;

use App\Models\Category;
use Illuminate\Support\Str;

class CreateCategoryAction
{
    /**
     * Maak een nieuwe categorie aan.
     */
    public function handle(array $data): Category
    {
        // Als de frontend geen slug meestuurt, genereren we er automatisch een op basis van de naam
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // is_active checkbox afhandeling (als hij niet in array zit is hij false)
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : true;

        return Category::create($data);
    }
}
