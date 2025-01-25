<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\Category;
use App\Models\User;

class SalesTableSeeder extends Seeder
{
    public function run()
    {
        $category = Category::first();
        $user = User::first();

        Sale::create([
            'product' => 'Producto 1',
            'description' => 'Descripción del producto 1',
            'price' => 100.00,
            'isSold' => false,
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        Sale::create([
            'product' => 'Producto 2',
            'description' => 'Descripción del producto 2',
            'price' => 200.00,
            'isSold' => false,
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
    }
}