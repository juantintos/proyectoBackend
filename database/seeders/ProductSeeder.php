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
            [
                'code'  => 'PRD-20250516-A3F2',
                'name'  => 'Mouse Inalámbrico',
                'brand' => 'Logitech',
                'price' => 25.99,
            ],
            [
                'code'  => 'PRD-20250516-B4G3',
                'name'  => 'Teclado USB',
                'brand' => 'HP',
                'price' => 32.50,
            ],
            [
                'code'  => 'PRD-20250516-C5H4',
                'name'  => 'Monitor 24 Pulgadas',
                'brand' => 'Samsung',
                'price' => 219.99,
            ],
            [
                'code'  => 'PRD-20250516-D6J5',
                'name'  => 'Laptop Empresarial',
                'brand' => 'Dell',
                'price' => 899.00,
            ],
            [
                'code'  => 'PRD-20250516-E7K6',
                'name'  => 'Impresora Multifuncional',
                'brand' => 'Epson',
                'price' => 179.99,
            ],
            [
                'code'  => 'PRD-20250516-F8L7',
                'name'  => 'Disco SSD 512GB',
                'brand' => 'Kingston',
                'price' => 84.99,
            ],
            [
                'code'  => 'PRD-20250516-G9M8',
                'name'  => 'Memoria USB 64GB',
                'brand' => 'Sandisk',
                'price' => 15.99,
            ],
            [
                'code'  => 'PRD-20250516-H0N9',
                'name'  => 'Router WiFi',
                'brand' => 'TP-Link',
                'price' => 69.99,
            ],
            [
                'code'  => 'PRD-20250516-I1O0',
                'name'  => 'Silla de Oficina',
                'brand' => 'OfficePro',
                'price' => 249.99,
            ],
            [
                'code'  => 'PRD-20250516-J2P1',
                'name'  => 'Escritorio Ejecutivo',
                'brand' => 'Mobility',
                'price' => 399.99,
            ],
            [
                'code'  => 'PRD-20250516-K3Q2',
                'name'  => 'Webcam Full HD',
                'brand' => 'Logitech',
                'price' => 59.99,
            ],
            [
                'code'  => 'PRD-20250516-L4R3',
                'name'  => 'Audífonos Bluetooth',
                'brand' => 'Sony',
                'price' => 129.99,
            ],
            [
                'code'  => 'PRD-20250516-M5S4',
                'name'  => 'Tablet 10 Pulgadas',
                'brand' => 'Lenovo',
                'price' => 329.99,
            ],
            [
                'code'  => 'PRD-20250516-N6T5',
                'name'  => 'UPS Regulador',
                'brand' => 'APC',
                'price' => 189.99,
            ],
            [
                'code'  => 'PRD-20250516-O7U6',
                'name'  => 'Proyector Empresarial',
                'brand' => 'BenQ',
                'price' => 799.99,
            ],
        ];

        foreach ($products as $data) {
            Product::create($data);
        }

        $this->command->info('Productos creados: ' . count($products));
    }
}