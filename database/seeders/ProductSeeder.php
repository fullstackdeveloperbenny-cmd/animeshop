<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $mangaCategory = Category::where('name', 'Manga')->first();
        $kledingCategory = Category::where('name', 'Kleding')->first();

        if ($mangaCategory) {
            $product1 = Product::create([
                'category_id' => $mangaCategory->id,
                'name' => 'Naruto Vol. 1',
                'slug' => Str::slug('Naruto Vol. 1'),
                'description' => 'De allereerste manga van Naruto!',
                'price' => 9.99,
                'badge' => 'NIEUW',
                'is_active' => true,
                'is_featured' => true,
            ]);

            $product1->variants()->create([
                'type' => 'Taal',
                'value' => 'NL',
                'stock' => 10,
                'price_modifier' => 0,
            ]);
        }

        if ($kledingCategory) {
            $product2 = Product::create([
                'category_id' => $kledingCategory->id,
                'name' => 'Akatsuki Hoodie',
                'slug' => Str::slug('Akatsuki Hoodie'),
                'description' => 'Comfortabele hoodie met de rode wolken van de Akatsuki.',
                'price' => 49.99,
                'badge' => 'SALE',
                'is_active' => true,
                'is_featured' => true,
            ]);

            foreach (['S', 'M', 'L'] as $size) {
                $product2->variants()->create([
                    'type' => 'Maat',
                    'value' => $size,
                    'stock' => 5,
                    'price_modifier' => 0,
                ]);
            }
        }
    }
}
