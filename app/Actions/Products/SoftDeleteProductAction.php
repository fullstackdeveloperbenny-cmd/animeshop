<?php

namespace App\Actions\Products;

use App\Models\Product;

class SoftDeleteProductAction
{
    public function handle(Product $product): bool
    {
        // Varianten en images blijven gewoon bewaard in de database.
        // Dankzij het feit dat het Product een 'soft delete' datum krijgt,
        // filtert Laravel deze er automatisch uit in de webshop!
        return $product->delete();
    }
}
