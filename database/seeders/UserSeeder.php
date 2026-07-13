<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kiu.test'],
            ['name' => 'KIU Career Admin', 'password' => 'password', 'role' => User::ROLE_ADMIN]
        );

        User::updateOrCreate(
            ['email' => 'student@kiu.test'],
            ['name' => 'Nino Beridze', 'password' => 'password', 'role' => User::ROLE_STUDENT]
        );

        User::updateOrCreate(
            ['email' => 'professor@kiu.test'],
            ['name' => 'Dr. Giorgi Kvirikashvili', 'password' => 'password', 'role' => User::ROLE_PROFESSOR]
        );
    }
}
