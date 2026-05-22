<?php

namespace Database\Seeders;

use App\Models\Category_product;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales;
use App\Models\User;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Owner',
            'email' => 'owner@example.com',
            'password' => '123',
            'access_level' => 3,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '123',
            'access_level' => 1,
        ]);

        Customer::create([
            'name' => 'Guest',
            'phone_no' => '00000000',
            'address' => 'Guest Home',
        ]);

        Sales::create([
            'id' => 1,
        ]);

        Category_product::create([
            'name' => 'Kopi',
        ]);

        Category_product::create([
            'name' => 'Mie Instan',
        ]);

        Category_product::create([
            'name' => 'Minyak',
        ]);

        Category_product::create([
            'name' => 'Sabun',
        ]);

        Category_product::create([
            'name' => 'Bahan Masak',
        ]);

        Product::create([
            'name' => 'Product 1',
            'brand' => 'Brand 1',
            'category_id' => 1,
            'qty_instock' => 10,
            'price' => 10000,
        ]);

        Product::create([
            'name' => 'Product 2',
            'brand' => 'Brand 2',
            'category_id' => 2,
            'qty_instock' => 5,
            'price' => 5000,
        ]);

        Product::create([
            'name' => 'Product 3',
            'brand' => 'Brand 3',
            'category_id' => 3,
            'qty_instock' => 1,
            'price' => 1000,
        ]);
    }
}
