<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::truncate();

        $profiles = [
            [
                'name'     => 'Administrador',
                'permissions' => ['products', 'users', 'profiles', 'audit'],
            ],
            [
                'name'     => 'Ventas',
                'permissions' => ['products'],
            ],
            [
                'name'     => 'RRHH',
                'permissions' => ['users'],
            ],
            [
                'name'     => 'Supervisor',
                'permissions' => ['products', 'users', 'audit'],
            ],
        ];

        foreach ($profiles as $data) {
            Profile::create($data);
        }

        $this->command->info('  Perfiles creados: ' . count($profiles));
    }
}
