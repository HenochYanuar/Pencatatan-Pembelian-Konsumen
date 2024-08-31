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
            'name' => 'ABC',
            'description' => 'cetak ABC',
            'price' => 1000.00,
            'category' => 'cetak digital',
        ]);

        Product::create([
            'name' => 'XYZ',
            'description' => 'copy XYZ',
            'price' => 100.00,
            'category' => 'fotocopy',
        ]);
    }
}
