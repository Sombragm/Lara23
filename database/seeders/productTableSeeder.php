<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class productTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Product 1',
            'description' => 'Short description of Product 1',
            'descriptionLong' => 'Long description of Product 1',
            'price' => 19.99,
            'category_id' => 1, // Assuming category with ID 1 exists
        ]);
    }
}
