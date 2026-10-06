<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DemoUsersSeeder extends Seeder
{
    public const PASSWORD = 'Password123!';

    public function run(): void
    {
        abort_unless(app()->environment(['local', 'testing']), 403, 'Este seeder es exclusivo del entorno local.');

        foreach ([
            ['name' => 'Administrador', 'email' => 'admin@example.com', 'role' => 'admin'],
            ['name' => 'Supervisor', 'email' => 'supervisor@example.com', 'role' => 'supervisor'],
            ['name' => 'Usuario', 'email' => 'usuario@example.com', 'role' => 'usuario'],
        ] as $account) {
            $user = User::firstOrCreate(
                ['email' => $account['email']],
                ['name' => $account['name'], 'password' => self::PASSWORD],
            );

            $user->syncRoles([$account['role']]);
        }
    }
}
