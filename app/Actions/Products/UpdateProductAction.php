<?php

namespace App\Actions\Products;

use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Support\Str;

class UpdateProductAction
{
    public function __construct(protected ProductImageService $imageService) {}

    public function handle(Product $product, array $data): Product
    {
        if (empty($data['slug']) && isset($data['name']) && $data['name'] !== $product->name) {
            $data['slug'] = Str::slug($data['name']);
        } elseif (empty($data['slug'])) {
            unset($data['slug']);
        }

        $data['is_active'] = array_key_exists('is_active', $data) ? (bool) $data['is_active'] : false;
        $data['is_featured'] = array_key_exists('is_featured', $data) ? (bool) $data['is_featured'] : false;

        $product->update($data);

        // Update varianten door alle oude weg te gooien en de nieuwe op te slaan.
        // Dit is de makkelijkste "sync" methode voor webshops.
        if (isset($data['variants'])) {
            $product->variants()->delete();
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

        // Afbeeldingen toevoegen (als er nieuwe geüpload zijn)
        if (!empty($data['images']) && is_array($data['images'])) {
            $hasPrimary = $product->images()->where('is_primary', true)->exists();
            foreach ($data['images'] as $index => $imageFile) {
                // Als we nog geen hoofdfoto hebben, is de eerste nieuwe meteen de hoofdfoto
                $isPrimary = (!$hasPrimary && $index === 0);
                $this->imageService->store($imageFile, $product, $isPrimary);
            }
        }

        return $product;
    }
}
