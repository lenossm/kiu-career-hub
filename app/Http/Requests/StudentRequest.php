<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        if (! $user) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        return $user->isStudent() && $this->routeIs('my.profile.*');
    }

    public function rules(): array
    {
        $studentId = $this->user()->student?->id ?? $this->route('student')?->id;

        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('students', 'email')->ignore($studentId)],
            'faculty' => ['required', 'string', 'max:255'],
            'short_bio' => ['required', 'string'],
            'skills' => ['required', 'string'],
            'experience' => ['nullable', 'string'],
            'portfolio_link' => ['nullable', 'url', 'max:255'],
            'github_link' => ['nullable', 'url', 'max:255'],
            'linkedin_link' => ['nullable', 'url', 'max:255'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
