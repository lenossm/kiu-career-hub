<?php

use App\Http\Controllers\Api\ApplicationController as ApiApplicationController;
use App\Http\Controllers\Api\StudentController as ApiStudentController;
use App\Http\Controllers\Api\VacancyController as ApiVacancyController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('v1')->group(function () {
    Route::apiResource('vacancies', ApiVacancyController::class)->names('api.vacancies');
    Route::apiResource('students', ApiStudentController::class)->names('api.students');
    Route::get('applications', [ApiApplicationController::class, 'index'])->name('api.applications.index');
    Route::get('applications/{application}', [ApiApplicationController::class, 'show'])->name('api.applications.show');
});
