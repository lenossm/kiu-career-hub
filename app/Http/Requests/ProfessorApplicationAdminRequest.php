<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfessorApplicationAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'cover_letter' => ['required', 'string'],
            'status' => ['required', Rule::in(['pending', 'reviewed', 'accepted', 'rejected'])],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:4096'],
        ];
    }
}
