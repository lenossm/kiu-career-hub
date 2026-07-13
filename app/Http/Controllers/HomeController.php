<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ProfessorApplication;
use App\Models\Student;
use App\Models\Task;
use App\Models\Vacancy;

class HomeController extends Controller
{
    public function index()
    {
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();

        $featuredVacancy = Vacancy::query()
            ->forStudents()
            ->where('status', 'pending')
            ->orderBy('deadline')
            ->first();

        return view('home', [
            'stats' => [
                'student_vacancies' => Vacancy::query()->forStudents()->where('status', 'pending')->count(),
                'professor_vacancies' => Vacancy::query()->forProfessors()->where('status', 'pending')->count(),
                'applications_total' => Application::query()->count() + ProfessorApplication::query()->count(),
                'tasks_due_week' => Task::query()
                    ->where('status', 'pending')
                    ->whereBetween('deadline', [$weekStart, $weekEnd])
                    ->count(),
            ],
            'featuredVacancy' => $featuredVacancy,
            'students_total' => Student::query()->count(),
        ]);
    }
}
