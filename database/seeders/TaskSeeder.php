<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        Task::query()->delete();

        $rows = [
            [
                'title' => 'Review frontend internship applications',
                'description' => 'Screen cover letters and match skills to the Codevelop role.',
                'status' => 'pending',
                'deadline' => '2026-05-06',
            ],
            [
                'title' => 'Check expired vacancy deadlines',
                'description' => 'Close or extend listings past their deadline date.',
                'status' => 'pending',
                'deadline' => '2026-05-07',
            ],
            [
                'title' => 'Contact Creative Studio about UI/UX role',
                'description' => 'Confirm hours and hybrid schedule for the assistant posting.',
                'status' => 'pending',
                'deadline' => '2026-05-09',
            ],
            [
                'title' => 'Prepare shortlist for QA Tester Intern',
                'description' => 'Pick top student profiles to share with Softline Academy.',
                'status' => 'pending',
                'deadline' => '2026-05-11',
            ],
            [
                'title' => 'Update student profile records',
                'description' => 'Merge duplicate skills text and fix broken portfolio links.',
                'status' => 'done',
                'deadline' => '2026-05-04',
            ],
        ];

        foreach ($rows as $row) {
            Task::updateOrCreate(
                ['title' => $row['title']],
                $row
            );
        }
    }
}
