<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ProfessorApplication;
use App\Models\Student;
use App\Models\Task;
use App\Models\Vacancy;

class DashboardController extends Controller
{
    public function index()
    {
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();

        $studentAppCount = Application::query()->count();
        $facultyAppCount = ProfessorApplication::query()->count();

        return view('dashboard', [
            'stats' => [
                'vacancies_total' => Vacancy::query()->count(),
                'vacancies_pending' => Vacancy::query()->where('status', 'pending')->count(),
                'vacancies_student' => Vacancy::query()->forStudents()->where('status', 'pending')->count(),
                'vacancies_faculty' => Vacancy::query()->forProfessors()->where('status', 'pending')->count(),
                'vacancies_done' => Vacancy::query()->where('status', 'done')->count(),
                'applications_total' => $studentAppCount + $facultyAppCount,
                'applications_student' => $studentAppCount,
                'applications_faculty' => $facultyAppCount,
                'applications_pending' => Application::query()->where('status', 'pending')->count()
                    + ProfessorApplication::query()->where('status', 'pending')->count(),
                'students_total' => Student::query()->count(),
                'tasks_total' => Task::query()->count(),
                'tasks_due_week' => Task::query()
                    ->where('status', 'pending')
                    ->whereBetween('deadline', [$weekStart, $weekEnd])
                    ->count(),
            ],
            'recentVacancies' => Vacancy::query()
                ->orderBy('deadline')
                ->orderByDesc('id')
                ->limit(6)
                ->get(),
            'recentApplications' => Application::query()
                ->with(['student', 'vacancy'])
                ->orderByDesc('id')
                ->limit(4)
                ->get(),
            'recentFacultyApplications' => ProfessorApplication::query()
                ->with(['professor', 'vacancy'])
                ->orderByDesc('id')
                ->limit(4)
                ->get(),
        ]);
    }
}
