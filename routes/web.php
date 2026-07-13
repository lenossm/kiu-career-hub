<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\ProfessorApplicationController;
use App\Http\Controllers\ProfessorPortalController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentFeedController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\VacancyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/demo-login/{role}', [AuthController::class, 'demoLogin'])
    ->whereIn('role', ['admin', 'student', 'professor'])
    ->name('demo.login');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    // --- student area (own profile + student-only vacancies) ---
    Route::middleware('student')->prefix('student')->name('student.')->group(function () {
        Route::get('/vacancies', [StudentFeedController::class, 'index'])->name('vacancies.index');
        Route::get('/feed', [StudentFeedController::class, 'index'])->name('feed');
        Route::get('/vacancies/{vacancy}', [StudentFeedController::class, 'show'])->name('vacancies.show');
        Route::get('/vacancies/{vacancy}/apply', [ApplicationController::class, 'studentCreate'])->name('apply');
        Route::post('/vacancies/{vacancy}/apply', [ApplicationController::class, 'studentStore'])->name('apply.store');
    });

    Route::middleware('student')->group(function () {
        Route::get('/my-profile', [MyProfileController::class, 'show'])->name('my.profile.show');
        Route::get('/my-profile/create', [MyProfileController::class, 'create'])->name('my.profile.create');
        Route::post('/my-profile', [MyProfileController::class, 'store'])->name('my.profile.store');
        Route::get('/my-profile/edit', [MyProfileController::class, 'edit'])->name('my.profile.edit');
        Route::put('/my-profile', [MyProfileController::class, 'update'])->name('my.profile.update');
    });

    // --- faculty portal (separate vacancy list) ---
    Route::middleware('professor')->prefix('professor')->name('professor.')->group(function () {
        Route::get('/portal', [ProfessorPortalController::class, 'index'])->name('portal');
        Route::get('/vacancies/{vacancy}', [ProfessorPortalController::class, 'showVacancy'])->name('vacancies.show');
        Route::get('/profile/create', [ProfessorPortalController::class, 'createProfile'])->name('profile.create');
        Route::post('/profile', [ProfessorPortalController::class, 'storeProfile'])->name('profile.store');
        Route::get('/profile/edit', [ProfessorPortalController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [ProfessorPortalController::class, 'updateProfile'])->name('profile.update');
        Route::get('/vacancies/{vacancy}/apply', [ProfessorApplicationController::class, 'create'])->name('apply');
        Route::post('/vacancies/{vacancy}/apply', [ProfessorApplicationController::class, 'store'])->name('apply.store');
    });

    // --- career office (admin middleware on everything below) ---
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/vacancies/create', [VacancyController::class, 'create'])->name('vacancies.create');
        Route::post('/vacancies', [VacancyController::class, 'store'])->name('vacancies.store');
        Route::get('/vacancies/{vacancy}/edit', [VacancyController::class, 'edit'])->name('vacancies.edit');
        Route::put('/vacancies/{vacancy}', [VacancyController::class, 'update'])->name('vacancies.update');
        Route::delete('/vacancies/{vacancy}', [VacancyController::class, 'destroy'])->name('vacancies.destroy');
        Route::patch('/vacancies/{vacancy}/toggle-status', [VacancyController::class, 'toggleStatus'])->name('vacancies.toggleStatus');

        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
        Route::patch('/tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('tasks.toggleStatus');

        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
        Route::get('/applications/{application}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
        Route::put('/applications/{application}', [ApplicationController::class, 'update'])->name('applications.update');
        Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');

        Route::get('/professor-applications/{professorApplication}', [ProfessorApplicationController::class, 'show'])->name('professor-applications.show');
        Route::get('/professor-applications/{professorApplication}/edit', [ProfessorApplicationController::class, 'edit'])->name('professor-applications.edit');
        Route::put('/professor-applications/{professorApplication}', [ProfessorApplicationController::class, 'update'])->name('professor-applications.update');
        Route::delete('/professor-applications/{professorApplication}', [ProfessorApplicationController::class, 'destroy'])->name('professor-applications.destroy');

        Route::get('/vacancies/{vacancy}/apply', [ApplicationController::class, 'create'])->name('vacancies.apply');
        Route::post('/vacancies/{vacancy}/apply', [ApplicationController::class, 'store'])->name('vacancies.apply.store');
    });

    Route::middleware('admin')->get('/vacancies', [VacancyController::class, 'index'])->name('vacancies.index');
    Route::middleware('admin')->get('/vacancies/{vacancy}', [VacancyController::class, 'show'])->name('vacancies.show');
});

Route::redirect('/home', '/');
