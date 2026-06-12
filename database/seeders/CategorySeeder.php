<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Kledij (Hoofdcategorie)
        $kledij = Category::create([
            'name' => 'Kledij',
            'slug' => Str::slug('Kledij'),
        ]);

        Category::create([
            'parent_id' => $kledij->id,
            'name' => 'T-shirts',
            'slug' => Str::slug('T-shirts'),
        ]);

        Category::create([
            'parent_id' => $kledij->id,
            'name' => 'Hoodies',
            'slug' => Str::slug('Hoodies'),
        ]);

        // 2. Poppetjes (Hoofdcategorie)
        $figures = Category::create([
            'name' => 'Figures & Poppetjes',
            'slug' => Str::slug('Figures & Poppetjes'),
        ]);

        Category::create([
            'parent_id' => $figures->id,
            'name' => 'Nendoroids',
            'slug' => Str::slug('Nendoroids'),
        ]);

        Category::create([
            'parent_id' => $figures->id,
            'name' => 'Funko Pops',
            'slug' => Str::slug('Funko Pops'),
        ]);
        
        // 3. Manga (Hoofdcategorie)
        Category::create([
            'name' => 'Manga',
            'slug' => Str::slug('Manga'),
        ]);
    }
}
