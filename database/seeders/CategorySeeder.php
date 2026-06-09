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
        $categories = [
            [
                'name' => 'Céréales',
                'icon' => 'fa-wheat-awn',
                'description' => 'Maïs, riz, sorgho, mil et autres céréales.',
            ],
            [
                'name' => 'Tubercules',
                'icon' => 'fa-seedling',
                'description' => 'Manioc, igname, patate douce et pommes de terre.',
            ],
            [
                'name' => 'Légumes',
                'icon' => 'fa-carrot',
                'description' => 'Tomates, choux, carottes, poivrons et légumes frais.',
            ],
            [
                'name' => 'Fruits',
                'icon' => 'fa-apple-whole',
                'description' => 'Bananes, mangues, ananas, papayes et agrumes.',
            ],
            [
                'name' => 'Légumineuses',
                'icon' => 'fa-seedling',
                'description' => 'Haricots, pois, soja et arachides.',
            ],
            [
                'name' => 'Épices et Condiments',
                'icon' => 'fa-pepper-hot',
                'description' => 'Piment, gingembre, ail et épices locales.',
            ],
            [
                'name' => 'Café',
                'icon' => 'fa-mug-hot',
                'description' => 'Production de café arabica et robusta.',
            ],
            [
                'name' => 'Cacao',
                'icon' => 'fa-seedling',
                'description' => 'Fèves de cacao et produits dérivés.',
            ],
            [
                'name' => 'Huile de Palme',
                'icon' => 'fa-droplet',
                'description' => 'Huile de palme brute et raffinée.',
            ],
            [
                'name' => 'Produits Laitiers',
                'icon' => 'fa-cow',
                'description' => 'Lait, yaourts et produits dérivés.',
            ],
            [
                'name' => 'Volaille',
                'icon' => 'fa-drumstick-bite',
                'description' => 'Poulets, dindes et œufs.',
            ],
            [
                'name' => 'Bétail',
                'icon' => 'fa-cow',
                'description' => 'Bovins, ovins et caprins.',
            ],
            [
                'name' => 'Poissons et Fruits de Mer',
                'icon' => 'fa-fish',
                'description' => 'Poissons frais, fumés et crustacés.',
            ],
            [
                'name' => 'Miel et Apiculture',
                'icon' => 'fa-jar',
                'description' => 'Miel naturel et produits apicoles.',
            ],
            [
                'name' => 'Noix et Graines',
                'icon' => 'fa-seedling',
                'description' => 'Noix de cajou, graines diverses et oléagineux.',
            ],
            [
                'name' => 'Plantes Médicinales',
                'icon' => 'fa-leaf',
                'description' => 'Plantes utilisées en phytothérapie.',
            ],
            [
                'name' => 'Fleurs et Pépinières',
                'icon' => 'fa-spa',
                'description' => 'Fleurs ornementales et plants agricoles.',
            ],
            [
                'name' => 'Produits Transformés',
                'icon' => 'fa-box',
                'description' => 'Produits agricoles transformés localement.',
            ],
            [
                'name' => 'Alimentation Animale',
                'icon' => 'fa-bowl-food',
                'description' => 'Fourrages et aliments pour élevage.',
            ],
            [
                'name' => 'Autres Produits Agricoles',
                'icon' => 'fa-leaf',
                'description' => 'Autres productions agricoles diverses.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'description' => $category['description'],
                'is_active' => true,
            ]);
        }
    }
}
