<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
            'description' => ['required', 'string'],
            'deadline' => ['required', 'date'],
            'status' => $statusRule,
        ];
    }
}
