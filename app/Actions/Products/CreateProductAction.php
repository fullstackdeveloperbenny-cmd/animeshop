<?php

namespace App\Actions\Products;

use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateProductAction
{
    public function __construct(
        private ProductImageService $imageService
    ) {}

    public function handle(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $product = Product::create([
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
                $this->imageService->storeImages($product, $data['images'], $data['primary_image_index'] ?? 0);
            }

            if (isset($data['variants']) && is_array($data['variants'])) {
                foreach ($data['variants'] as $variantData) {
                    if (!empty($variantData['value'])) {
                        $product->variants()->create([
                            'type' => $variantData['type'],
                            'value' => $variantData['value'],
                            'stock' => $variantData['stock'] ?? 0,
                            'price_modifier' => $variantData['price_modifier'] ?? 0,
                        ]);
                    }
                }
            }

            return $product;
        });
    }
}
