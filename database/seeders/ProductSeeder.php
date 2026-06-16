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
        $manga = Category::where('name', 'Manga')->first();
        $tshirts = Category::where('name', 'T-shirts')->first();
        $hoodies = Category::where('name', 'Hoodies')->first();
        $nendoroids = Category::where('name', 'Nendoroids')->first();
        $funkos = Category::where('name', 'Funko Pops')->first();

        $productsData = [
            // Manga (5)
            ['cat' => $manga, 'name' => 'Naruto Vol. 1', 'price' => 9.99, 'badge' => 'NIEUW', 'desc' => 'De allereerste manga van Naruto!', 'variants' => ['Taal' => ['NL', 'EN']]],
            ['cat' => $manga, 'name' => 'One Piece Vol. 100', 'price' => 9.99, 'badge' => null, 'desc' => 'De legendarische 100ste volume van One Piece!', 'variants' => ['Taal' => ['NL', 'EN', 'FR']]],
            ['cat' => $manga, 'name' => 'Attack on Titan Vol. 34', 'price' => 10.99, 'badge' => 'SALE', 'desc' => 'Het epische einde van AOT.', 'variants' => ['Taal' => ['NL', 'EN']]],
            ['cat' => $manga, 'name' => 'Demon Slayer Vol. 1', 'price' => 8.99, 'badge' => null, 'desc' => 'Het begin van Tanjiro\'s reis.', 'variants' => ['Taal' => ['EN']]],
            ['cat' => $manga, 'name' => 'Jujutsu Kaisen Vol. 0', 'price' => 9.99, 'badge' => 'POPULAIR', 'desc' => 'De prequel van de hitserie.', 'variants' => ['Taal' => ['NL', 'EN']]],
            
            // Kleding - T-shirts (3)
            ['cat' => $tshirts, 'name' => 'Goku Super Saiyan T-shirt', 'price' => 24.99, 'badge' => null, 'desc' => 'Officieel Dragon Ball Z T-shirt.', 'variants' => ['Maat' => ['S', 'M', 'L', 'XL']]],
            ['cat' => $tshirts, 'name' => 'Levi Ackerman T-shirt', 'price' => 29.99, 'badge' => 'NIEUW', 'desc' => 'T-shirt met de sterkste soldaat.', 'variants' => ['Maat' => ['M', 'L']]],
            ['cat' => $tshirts, 'name' => 'Totoro Minimalist Shirt', 'price' => 22.99, 'badge' => null, 'desc' => 'Schattig Ghibli design.', 'variants' => ['Maat' => ['S', 'M', 'L']]],

            // Kleding - Hoodies (3)
            ['cat' => $hoodies, 'name' => 'Akatsuki Hoodie', 'price' => 49.99, 'badge' => 'SALE', 'desc' => 'Comfortabele hoodie met rode wolken.', 'variants' => ['Maat' => ['S', 'M', 'L']]],
            ['cat' => $hoodies, 'name' => 'U.A. High School Hoodie', 'price' => 54.99, 'badge' => null, 'desc' => 'My Hero Academia school uniform hoodie.', 'variants' => ['Maat' => ['M', 'L', 'XL']]],
            ['cat' => $hoodies, 'name' => 'Gojo Satoru Hoodie', 'price' => 59.99, 'badge' => 'POPULAIR', 'desc' => 'Premium kwaliteit JJK hoodie.', 'variants' => ['Maat' => ['S', 'L']]],

            // Figures - Nendoroids (3)
            ['cat' => $nendoroids, 'name' => 'Nendoroid Nezuko', 'price' => 64.99, 'badge' => null, 'desc' => 'Schattige Nezuko Nendoroid incl. doos.', 'variants' => []],
            ['cat' => $nendoroids, 'name' => 'Nendoroid Edward Elric', 'price' => 69.99, 'badge' => 'RESTOCK', 'desc' => 'Fullmetal Alchemist Nendoroid met accessoires.', 'variants' => []],
            ['cat' => $nendoroids, 'name' => 'Nendoroid Saitama', 'price' => 59.99, 'badge' => null, 'desc' => 'One Punch Man Nendoroid.', 'variants' => []],

            // Figures - Funko Pops (2)
            ['cat' => $funkos, 'name' => 'Funko Pop! Deku (Glow)', 'price' => 19.99, 'badge' => 'LIMITED', 'desc' => 'Special Edition Glow in the dark Deku.', 'variants' => []],
            ['cat' => $funkos, 'name' => 'Funko Pop! Hisoka', 'price' => 14.99, 'badge' => null, 'desc' => 'Hunter x Hunter Hisoka.', 'variants' => []],
        ];

        foreach ($productsData as $data) {
            if (!$data['cat']) continue;

            $product = Product::create([
                'category_id' => $data['cat']->id,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['desc'],
                'price' => $data['price'],
                'badge' => $data['badge'],
                'is_active' => true,
                'is_featured' => rand(1, 10) > 7, // 30% kans op featured
            ]);

            if (!empty($data['variants'])) {
                foreach ($data['variants'] as $type => $values) {
                    foreach ($values as $value) {
                        $product->variants()->create([
                            'type' => $type,
                            'value' => $value,
                            'stock' => rand(0, 15),
                            'price_modifier' => 0,
                        ]);
                    }
                }
            } else {
                // Product zonder variant, standaard 1 'Standaard' variant toevoegen als fallback
                $product->variants()->create([
                    'type' => 'Standaard',
                    'value' => 'One Size',
                    'stock' => rand(1, 10),
                    'price_modifier' => 0,
                ]);
            }
        }
    }
}
