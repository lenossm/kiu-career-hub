<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Student;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        if (Application::query()->exists()) {
            return;
        }

        $students = Student::all();
        $vacancies = Vacancy::query()->forStudents()->get();

        if ($students->isEmpty() || $vacancies->isEmpty()) {
            return;
        }

        Application::create([
            'student_id' => $students->first()->id,
            'vacancy_id' => $vacancies->first()->id,
            'cover_letter' => 'I am excited to apply. I enjoy building web products and learning quickly. I would love to contribute and grow with your team.',
            'status' => 'pending',
        ]);

        Application::factory()->count(8)->create([
            'student_id' => $students->random()->id,
            'vacancy_id' => $vacancies->random()->id,
        ]);
    }
}

