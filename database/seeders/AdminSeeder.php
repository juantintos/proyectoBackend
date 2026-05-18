<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use App\Services\CodeGeneratorService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function __construct(
        private readonly CodeGeneratorService $codeGenerator,
    ) {}

    public function run(): void
    {
        // Perfil administrador con todos los permisos
        $profile = Profile::firstOrCreate(
            ['name' => 'Administrador'],
            [
                'code'        => $this->codeGenerator->generate('PRF'),
                'permissions' => ['products', 'users', 'profiles'],
            ]
        );

        // Usuario administrador
        User::firstOrCreate(
            ['email' => 'admin@adminsystem.com'],
            [
                'code'       => $this->codeGenerator->generate('USR'),
                'name'       => 'Administrador',
                'password'   => Hash::make('Admin123!'),
                'profile_id' => $profile->id,
                'avatar'     => 'avatars/default.png',
                'is_active'  => true,
            ]
        );
    }
}