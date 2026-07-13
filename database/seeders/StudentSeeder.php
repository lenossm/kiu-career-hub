<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'full_name' => 'Elene Molashvili',
                'email' => 'elene@example.com',
                'faculty' => 'Computer Science',
                'short_bio' => 'Motivated CS student focused on web development and clean UI.',
                'skills' => 'Laravel, JavaScript, MySQL, QA Testing, HTML, CSS',
                'experience' => 'Built student web projects, worked on frontend layouts, practiced Laravel CRUD applications.',
                'portfolio_link' => 'https://example.com',
                'github_link' => 'https://github.com/example',
                'linkedin_link' => 'https://linkedin.com/in/example',
            ],
            [
                'full_name' => 'Nika Beridze',
                'email' => 'nika@example.com',
                'faculty' => 'Computer Science',
                'short_bio' => 'Backend-focused student interested in data and systems.',
                'skills' => 'Python, Data Analysis, SQL, Backend Development',
                'experience' => 'Built academic projects and database systems.',
                'portfolio_link' => null,
                'github_link' => null,
                'linkedin_link' => null,
            ],
            [
                'full_name' => 'Mariam Kapanadze',
                'email' => 'mariam@example.com',
                'faculty' => 'Management',
                'short_bio' => 'Organized and communication-driven student with leadership skills.',
                'skills' => 'Communication, Excel, Project Management, Customer Support',
                'experience' => 'Worked on university event planning and team coordination.',
                'portfolio_link' => null,
                'github_link' => null,
                'linkedin_link' => null,
            ],
        ];

        foreach ($items as $item) {
            Student::updateOrCreate(
                ['email' => $item['email']],
                $item
            );
        }

        $demoStudent = User::query()->where('email', 'student@kiu.test')->first();

        if ($demoStudent) {
            Student::updateOrCreate(
                ['user_id' => $demoStudent->id],
                [
                    'full_name' => 'Nino Beridze',
                    'email' => 'student@kiu.test',
                    'faculty' => 'Computer Science',
                    'short_bio' => 'CS student passionate about Laravel, clean UI, and building useful campus products.',
                    'skills' => 'Laravel, PHP, JavaScript, MySQL, HTML, CSS, React',
                    'experience' => 'Built academic web apps, contributed to student projects, practiced full-stack Laravel development.',
                    'portfolio_link' => 'https://example.com',
                    'github_link' => 'https://github.com/example',
                    'linkedin_link' => 'https://linkedin.com/in/example',
                ]
            );
        }

        // Keep factories deterministic-ish across reruns: only add more if empty
        if (Student::query()->count() < 10) {
            Student::factory()->count(8)->create();
        }
    }
}

