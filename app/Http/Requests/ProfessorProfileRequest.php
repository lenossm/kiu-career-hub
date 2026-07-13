<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfessorProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isProfessor() ?? false;
    }

    public function rules(): array
    {
        $professorId = $this->user()->professor?->id;

        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('professors', 'email')->ignore($professorId)],
            'department' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
