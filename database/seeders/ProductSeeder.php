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
        $mangaCategory = Category::where('slug', 'manga')->first();
        $hoodiesCategory = Category::where('slug', 'hoodies')->first();
        $figuresCategory = Category::where('slug', 'figures-poppetjes')->first();

        // Voorbeeld Product 1: Manga
        if ($mangaCategory) {
            Product::create([
                'category_id' => $mangaCategory->id,
                'name' => 'Naruto Vol. 1',
                'slug' => Str::slug('Naruto Vol. 1'),
                'description' => 'De allereerste manga volume van Naruto. Beleef het avontuur vanaf het prille begin!',
                'price' => 12.99,
                'is_active' => true,
            ])->variants()->create([
                'type' => 'Taal',
                'value' => 'NL',
                'stock' => 50,
            ]);
        }

        // Voorbeeld Product 2: Hoodie
        if ($hoodiesCategory) {
            $hoodie = Product::create([
                'category_id' => $hoodiesCategory->id,
                'name' => 'Akatsuki Cloud Hoodie',
                'slug' => Str::slug('Akatsuki Cloud Hoodie'),
                'description' => 'Hoogwaardige hoodie met de iconische rode Akatsuki wolken. Gemaakt van comfortabel katoen.',
                'price' => 49.99,
                'badge' => 'Nieuw',
                'is_active' => true,
                'is_featured' => true,
            ]);

            // Meerdere varianten (maten) voor de hoodie
            $hoodie->variants()->createMany([
                ['type' => 'Maat', 'value' => 'S', 'stock' => 10],
                ['type' => 'Maat', 'value' => 'M', 'stock' => 15],
                ['type' => 'Maat', 'value' => 'L', 'stock' => 5],
            ]);
        }
    }
}
