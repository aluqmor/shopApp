<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
{
    $categories = [
        ['name' => 'Electrónica'],
        ['name' => 'Ropa'],
        ['name' => 'Hogar'],
        ['name' => 'Deportes'],
        ['name' => 'Videojuegos'],
        ['name' => 'Libros'],
        ['name' => 'Música'],
        ['name' => 'Belleza'],
        ['name' => 'Juguetes'],
        ['name' => 'Coches'],
    ];

    foreach ($categories as $category) {
        Category::create($category);
    }
}
}