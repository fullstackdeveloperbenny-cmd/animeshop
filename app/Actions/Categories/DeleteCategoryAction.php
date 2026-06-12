<?php

namespace App\Actions\Categories;

use App\Models\Category;

class DeleteCategoryAction
{
    /**
     * Verwijder een categorie via Soft Delete.
     */
    public function handle(Category $category): bool
    {
        // Dankzij de "nullOnDelete()" constraint in onze migratie,
        // zullen eventuele subcategorieën nu netjes hoofdcategorieën worden
        // wanneer de parent wordt verwijderd. Dit voorkomt dat hele
        // productbomen per ongeluk sneuvelen.

        return $category->delete();
    }
}
