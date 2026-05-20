<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::truncate();

        $adminProfile = Profile::where('name', 'Administrador')->first();
        $ventasProfile = Profile::where('name', 'Ventas')->first();
        $rrhhProfile = Profile::where('name', 'RRHH')->first();

        // ── Admin principal ──────────────────────────────────────────────────
        User::create([
            'name'     => 'Administrador Sistema',
            'email'    => 'admin@empresa.com',
            'password' => Hash::make('Admin123'),
            'phone'    => '+52 312 100 0000',
            'profile_id' => (string) $adminProfile->_id,
            'is_active' => true,
        ]);

        // ── Usuarios de prueba ───────────────────────────────────────────────
        $dummyUsers = [
            [
                'name'     => 'Carlos Mendoza',
                'email'    => 'carlos@empresa.com',
                'password' => Hash::make('password123'),
                'phone'    => '+52 312 111 2233',
                'profile_id' => (string) $ventasProfile->_id,
                'is_active' => true,
            ],
            [
                'name'     => 'Laura Jiménez',
                'email'    => 'laura@empresa.com',
                'password' => Hash::make('password123'),
                'phone'    => '+52 312 444 5566',
                'profile_id' => (string) $rrhhProfile->_id,
                'is_active' => true, 
            ],
            [
                'name'     => 'Miguel Torres',
                'email'    => 'miguel@empresa.com',
                'password' => Hash::make('password123'),
                'phone'    => '+52 312 777 8899',
                'profile_id' => (string) $ventasProfile->_id,
                'is_active' => true,
            ],
        ];

        foreach ($dummyUsers as $userData) {
            User::create($userData);
        }

        $this->command->info('  Usuarios creados: ' . (count($dummyUsers) + 1));
        $this->command->info('  Admin: admin@empresa.com / Admin123!');
    }
}
