<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class ProductImageService
{
    public function storeImages(Product $product, array $images, ?int $primaryIndex = 0): void
    {
        $manager = new ImageManager(new Driver());

        foreach ($images as $index => $image) {
            if ($image instanceof UploadedFile) {
                // Lees de originele afbeelding
                $img = $manager->decode($image->getPathname());
                
                // Verklein naar max 800x800 met behoud van verhoudingen
                $img->scaleDown(width: 800, height: 800);
                
                // Converteer naar WebP met 80% kwaliteit
                $encoded = $img->encode(new WebpEncoder(80));
                
                // Genereer een unieke bestandsnaam
                $filename = Str::uuid() . '.webp';
                $path = 'products/' . $filename;
                
                // Sla op de public disk
                Storage::disk('public')->put($path, $encoded->toString());

                // Koppel aan het product
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
