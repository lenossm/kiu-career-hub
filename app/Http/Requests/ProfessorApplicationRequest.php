<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfessorApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isProfessor() ?? false;
    }

    public function rules(): array
    {
        $vacancyId = $this->route('vacancy')?->id;
        $professorId = $this->user()->professor?->id;

        return [
            'cover_letter' => ['required', 'string'],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:4096'],
            'professor_id' => ['prohibited'],
            'vacancy_id' => [
                'prohibited',
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $professorId = $this->user()->professor?->id;
            $vacancyId = $this->route('vacancy')?->id;

            if ($professorId && $vacancyId) {
                $exists = \App\Models\ProfessorApplication::query()
                    ->where('professor_id', $professorId)
                    ->where('vacancy_id', $vacancyId)
                    ->exists();

                if ($exists) {
                    $validator->errors()->add('cover_letter', 'You already applied to this position.');
                }
            }
        });
    }
}
