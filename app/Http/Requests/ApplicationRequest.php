<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        if ($this->route('application')) {
            return [
                'cover_letter' => ['required', 'string'],
                'status' => ['required', Rule::in(['pending', 'reviewed', 'accepted', 'rejected'])],
                'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:4096'],
            ];
        }

        if ($this->routeIs('student.apply.store')) {
            return [
                'cover_letter' => ['required', 'string'],
                'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:4096'],
            ];
        }

        $vacancyId = $this->route('vacancy')?->id;

        return [
            'student_id' => [
                'required',
                'integer',
                Rule::exists('students', 'id'),
                Rule::unique('applications', 'student_id')->where(
                    fn ($query) => $query->where('vacancy_id', $vacancyId)
                ),
            ],
            'cover_letter' => ['required', 'string'],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:4096'],
        ];
    }
}
