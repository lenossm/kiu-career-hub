<?php

namespace Database\Seeders;

use App\Models\Professor;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfessorSeeder extends Seeder
{
    public function run(): void
    {
        $professorUser = User::query()->where('email', 'professor@kiu.test')->first();

        if ($professorUser) {
            Professor::updateOrCreate(
                ['user_id' => $professorUser->id],
                [
                    'full_name' => 'Dr. Giorgi Kvirikashvili',
                    'email' => 'professor@kiu.test',
                    'department' => 'Computer Science',
                    'bio' => 'Faculty member focused on software engineering, algorithms, and mentoring student research projects at KIU.',
                ]
            );
        }
    }
}
