<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    /**
     * Slaat een productafbeelding op in de storage en in de database.
     */
    public function store(UploadedFile $file, Product $product, bool $isPrimary = false): ProductImage
    {
        // Sla op in de public/products map
        $path = $file->store('products', 'public');
        
        return $product->images()->create([
            'path' => $path,
            'is_primary' => $isPrimary,
        ]);
    }

    /**
     * Verwijdert een afbeelding van het fysieke schijfgeheugen en uit de database.
     */
    public function delete(ProductImage $image): void
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();
    }
}
