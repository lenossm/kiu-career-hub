<?php

namespace Database\Seeders;

use App\Models\Vacancy;
use Illuminate\Database\Seeder;

class VacancySeeder extends Seeder
{
    public function run(): void
    {
        $studentVacancies = [
            [
                'title' => 'Frontend Developer Intern',
                'company' => 'Codevelop',
                'description' => "Join a student-friendly team to build modern UIs.\n\nTasks: components, layouts, and small features.",
                'required_skills' => 'HTML, CSS, JavaScript, React',
                'location' => 'Remote / Tbilisi',
                'type' => 'Internship',
                'audience' => Vacancy::AUDIENCE_STUDENT,
                'status' => 'pending',
                'deadline' => '2026-08-20',
            ],
            [
                'title' => 'Junior Laravel Developer',
                'company' => 'Digital Lab Georgia',
                'description' => "Work on Laravel features and Blade views.\n\nTasks: CRUD modules, validations, and UI polishing.",
                'required_skills' => 'PHP, Laravel, MySQL, Blade',
                'location' => 'Tbilisi',
                'type' => 'Part-time',
                'audience' => Vacancy::AUDIENCE_STUDENT,
                'status' => 'pending',
                'deadline' => '2026-08-25',
            ],
            [
                'title' => 'Data Analyst Intern',
                'company' => 'KIU Research Office',
                'description' => "Support analytics projects with Python and SQL.",
                'required_skills' => 'Python, SQL, Excel, Statistics',
                'location' => 'Kutaisi',
                'type' => 'Internship',
                'audience' => Vacancy::AUDIENCE_STUDENT,
                'status' => 'pending',
                'deadline' => '2026-09-01',
            ],
        ];

        $professorVacancies = [
            [
                'title' => 'Teaching Assistant — Computer Science',
                'company' => 'KIU Faculty of IT',
                'description' => "Support undergraduate labs and grading for programming courses.",
                'required_skills' => 'Teaching, PHP, Algorithms, Communication',
                'location' => 'KIU Campus, Kutaisi',
                'type' => 'Part-time',
                'audience' => Vacancy::AUDIENCE_PROFESSOR,
                'status' => 'pending',
                'deadline' => '2026-08-15',
            ],
            [
                'title' => 'Research Project Lead',
                'company' => 'KIU Research Center',
                'description' => "Lead a faculty research stream in applied AI for education.",
                'required_skills' => 'Research, Machine Learning, Project Management',
                'location' => 'KIU Campus',
                'type' => 'Full-time',
                'audience' => Vacancy::AUDIENCE_PROFESSOR,
                'status' => 'pending',
                'deadline' => '2026-09-10',
            ],
        ];

        foreach (array_merge($studentVacancies, $professorVacancies) as $item) {
            Vacancy::updateOrCreate(
                ['title' => $item['title'], 'company' => $item['company']],
                $item
            );
        }
    }
}
