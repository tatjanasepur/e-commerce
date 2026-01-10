<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse',
                'price' => 1299,
                'stock_quantity' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB mechanical keyboard',
                'price' => 7499,
                'stock_quantity' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'USB-C Cable',
                'description' => 'Fast charging USB-C cable',
                'price' => 499,
                'stock_quantity' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
