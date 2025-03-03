<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product_order;
use App\Models\Table;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Table::create([
        //     'no_meja' => 1
        // ]);

        // Order::create([
        //     'table_id' => 1
        // ]); 

        // Product_order::create([
        //     'id_product' => 1,
        //     'id_order' => 1,
        // ]);

        // User::factory(10)->create();

        User::create([
            'name' => 'Alifa Qadri',
            'email' => 'test@example.com',
            'isadmin'=>true,
            'password'=>'admin123'
        ]);

        Category::create([
            'nama_category'=>'mie'
        ]);

        Category::create([
            'nama_category'=>'nasi'
        ]);

        Category::create([
            'nama_category'=>'teh'
        ]);

        Category::create([
            'nama_category'=>'kopi'
        ]);

        Product::create([
            'nama_produk' => 'mie bangladesh',
            'stok' => 100,
            'harga' => 15000,
            'category_id'=> 1
        ]);

        Product::create([
            'nama_produk' => 'nasi goreng',
            'stok' => 100,
            'harga' => 13000,
            'category_id'=> 2
        ]);

        Product::create([
            'nama_produk' => 'ayam penyet',
            'stok' => 100,
            'harga' => 20000,
            'category_id'=> 2
        ]);

        Product::create([
            'nama_produk' => 'teh manis dingin',
            'stok' => 100,
            'harga' => 7000,
            'category_id'=> 3
        ]);

        Product::create([
            'nama_produk' => 'teh manis panas',
            'stok' => 100,
            'harga' => 6000,
            'category_id'=> 3
        ]);

        Product::create([
            'nama_produk' => 'kopi panas',
            'stok' => 100,
            'harga' => 8000,
            'category_id'=> 4
        ]);

        Product::create([
            'nama_produk' => 'kopi dingin',
            'stok' => 100,
            'harga' => 10000,
            'category_id'=> 4
        ]);

        Product::create([
            'nama_produk' => 'sanger panas',
            'stok' => 100,
            'harga' => 10000,
            'category_id'=> 4
        ]);

        Product::create([
            'nama_produk' => 'sanger dingin',
            'stok' => 100,
            'harga' => 10000,
            'category_id'=> 4
        ]);

    }
}
