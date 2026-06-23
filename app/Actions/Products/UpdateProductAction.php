<?php

namespace App\Actions\Products;

use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateProductAction
{
    public function __construct(
        private ProductImageService $imageService
    ) {}

    public function handle(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data) {
            $product->update([
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'price' => $data['price'],
                'badge' => $data['badge'] ?? null,
                'is_active' => $data['is_active'] ?? true,
                'is_featured' => $data['is_featured'] ?? false,
            ]);

            if (isset($data['images']) && is_array($data['images'])) {
                $this->imageService->deleteImages($product);
                $this->imageService->storeImages($product, $data['images'], $data['primary_image_index'] ?? 0);
            }

            $hasValidVariants = false;
            if (isset($data['variants']) && is_array($data['variants'])) {
                $product->variants()->delete();
                foreach ($data['variants'] as $variantData) {
                    if (!empty($variantData['value'])) {
                        $hasValidVariants = true;
                        $product->variants()->create([
                            'type' => $variantData['type'],
                            'value' => $variantData['value'],
                            'stock' => $variantData['stock'] ?? 0,
                            'price_modifier' => $variantData['price_modifier'] ?? 0,
                        ]);
                    }
                }
            }

            // Fallback: Als er geen varianten zijn, maar wel een base_stock
            if (!$hasValidVariants && isset($data['base_stock'])) {
                $product->variants()->delete(); // Zeker zijn dat oude varianten weg zijn
                $product->variants()->create([
                    'type' => 'Standaard',
                    'value' => 'One Size',
                    'stock' => $data['base_stock'],
                    'price_modifier' => 0,
                ]);
            }

            return $product;
        });
    }
}
