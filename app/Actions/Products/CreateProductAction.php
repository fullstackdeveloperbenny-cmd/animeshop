<?php

namespace App\Actions\Products;

use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Support\Str;

class CreateProductAction
{
    // We injecteren de image service zodat we die hier direct kunnen gebruiken
    public function __construct(protected ProductImageService $imageService) {}

    public function handle(array $data): Product
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : true;
        $data['is_featured'] = isset($data['is_featured']) ? (bool) $data['is_featured'] : false;

        $product = Product::create($data);

        // Varianten opslaan (als we later via het grote formulier varianten meesturen)
        if (!empty($data['variants']) && is_array($data['variants'])) {
            foreach ($data['variants'] as $variant) {
                if (!empty($variant['type']) && !empty($variant['value'])) {
                    $product->variants()->create([
                        'type' => $variant['type'],
                        'value' => $variant['value'],
                        'stock' => $variant['stock'] ?? 0,
                        'price_modifier' => $variant['price_modifier'] ?? 0,
                    ]);
                }
            }
        }

        // Afbeeldingen opslaan
        if (!empty($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $index => $imageFile) {
                // We maken de eerste geüploade foto automatisch de "hoofdfoto"
                $isPrimary = ($index === 0);
                $this->imageService->store($imageFile, $product, $isPrimary);
            }
        }

        return $product;
    }
}
