<?php

namespace App\Actions\Products;

use App\Models\Product;

class RestoreProductAction
{
    /**
     * Herstelt een product uit de prullenbak (SoftDeletes).
     */
    public function handle(Product $product): void
    {
        $product->restore();
    }
}
