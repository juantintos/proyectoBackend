<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::truncate();

        $products = [
            ['name' => 'Laptop Dell XPS 15',          'brand' => 'Dell',    'price' => 1299.99],
            ['name' => 'Monitor LG UltraWide 34"',    'brand' => 'LG',      'price' => 549.00],
            ['name' => 'Teclado Mecánico Keychron K2', 'brand' => 'Keychron','price' => 89.99],
            ['name' => 'Mouse Logitech MX Master 3',  'brand' => 'Logitech','price' => 99.99],
            ['name' => 'Auriculares Sony WH-1000XM5', 'brand' => 'Sony',    'price' => 349.99],
            ['name' => 'Webcam Logitech C920 HD',     'brand' => 'Logitech','price' => 69.99],
            ['name' => 'Hub USB-C Anker 7-en-1',      'brand' => 'Anker',   'price' => 39.99],
            ['name' => 'SSD Samsung 970 EVO 1TB',     'brand' => 'Samsung', 'price' => 109.99],
            ['name' => 'RAM Corsair 32GB DDR5',       'brand' => 'Corsair', 'price' => 129.99],
            ['name' => 'Silla Ergonómica Herman Miller','brand'=> 'Herman Miller', 'price' => 1299.00],
            ['name' => 'iPad Pro 12.9" M2',           'brand' => 'Apple',   'price' => 1099.00],
            ['name' => 'iPhone 15 Pro',               'brand' => 'Apple',   'price' => 999.00],
            ['name' => 'MacBook Air M3',              'brand' => 'Apple',   'price' => 1099.00],
            ['name' => 'Surface Pro 9',               'brand' => 'Microsoft','price'=> 1299.99],
            ['name' => 'Impresora HP LaserJet Pro',   'brand' => 'HP',      'price' => 249.99],
        ];

        foreach ($products as $data) {
            Product::create($data);
        }

        $this->command->info('  Productos creados: ' . count($products));
    }
}
