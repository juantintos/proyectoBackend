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
                'code'        => 'PRF-20250516-A3F4',
                'name'     => 'Administrador',
                'permissions' => ['products', 'users', 'profiles', 'audit'],
            ],
            [
                'code'        => 'PRF-20250516-B4G3',
                'name'     => 'Ventas',
                'permissions' => ['products'],
            ],
            [
                'code'        => 'PRF-20250516-C5H4',
                'name'     => 'RRHH',
                'permissions' => ['users'],
            ],
            [
                'code'        => 'PRF-20250516-D6J5',
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
