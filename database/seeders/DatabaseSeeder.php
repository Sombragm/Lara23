<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(productTableSeeder::class);
        $categories = Category::factory()->count(7)->create();

        $categories->each(function ($category) {
            Product::factory()->count(15)->create([
                'category_id' => $category->id,
            ]);
        });
        // User::factory(10)->create();

       // User::factory()->create([
       //     'name' => 'Test User',
       //     'email' => 'test@example.com',
       // ]);
    }
}
