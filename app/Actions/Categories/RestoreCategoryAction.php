<?php

namespace App\Actions\Categories;

use App\Models\Category;

class RestoreCategoryAction
{
    /**
     * Herstelt een categorie uit de prullenbak (SoftDeletes).
     */
    public function handle(Category $category): void
    {
        $category->restore();
    }
}
