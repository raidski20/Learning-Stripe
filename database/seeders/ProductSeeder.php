<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Product 1',
            'price' => 15.02,
        ]);

        Product::create([
            'name' => 'Product 2',
            'price' => 5.99,
        ]);

        Product::create([
            'name' => 'Product 3',
            'price' => 115.20,
        ]);
    }
}
