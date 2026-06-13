<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    public function storeImages(Product $product, array $images, ?int $primaryIndex = 0): void
    {
        foreach ($images as $index => $image) {
            if ($image instanceof UploadedFile) {
                $path = $image->store('products', 'public');

                $product->images()->create([
                    'path' => $path,
                    'is_primary' => ($index === (int)$primaryIndex),
                ]);
            }
        }
    }

    public function deleteImages(Product $product): void
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
    }
}
