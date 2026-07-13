<?php

namespace App\Http\Requests;

use App\Http\Controllers\VacancyController;
use App\Models\Vacancy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VacancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        $statusRule = $this->isMethod('post')
            ? ['nullable', Rule::in(['pending', 'done'])]
            : ['required', Rule::in(['pending', 'done'])];

        return [
            'title' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'required_skills' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', Rule::in(VacancyController::ALLOWED_TYPES)],
            'audience' => ['required', Rule::in([Vacancy::AUDIENCE_STUDENT, Vacancy::AUDIENCE_PROFESSOR])],
            'deadline' => ['required', 'date'],
            'status' => $statusRule,
        ];
    }
}
