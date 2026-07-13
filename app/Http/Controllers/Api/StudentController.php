<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query()->withCount('applications');

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($builder) use ($q) {
                $builder
                    ->where('full_name', 'like', "%{$q}%")
                    ->orWhere('faculty', 'like', "%{$q}%")
                    ->orWhere('skills', 'like', "%{$q}%");
            });
        }

        return StudentResource::collection(
            $query->orderByDesc('id')->paginate(10)
        );
    }

    public function show(Student $student)
    {
        $student->load(['vacancies'])->loadCount('applications');

        return new StudentResource($student);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'faculty' => ['required', 'string', 'max:255'],
            'short_bio' => ['required', 'string'],
            'skills' => ['required', 'string'],
            'experience' => ['nullable', 'string'],
            'portfolio_link' => ['nullable', 'url', 'max:255'],
            'github_link' => ['nullable', 'url', 'max:255'],
            'linkedin_link' => ['nullable', 'url', 'max:255'],
        ]);

        return (new StudentResource(Student::create($validated)))
            ->response()
            ->setStatusCode(201);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'full_name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255', Rule::unique('students', 'email')->ignore($student->id)],
            'faculty' => ['sometimes', 'required', 'string', 'max:255'],
            'short_bio' => ['sometimes', 'required', 'string'],
            'skills' => ['sometimes', 'required', 'string'],
            'experience' => ['nullable', 'string'],
            'portfolio_link' => ['nullable', 'url', 'max:255'],
            'github_link' => ['nullable', 'url', 'max:255'],
            'linkedin_link' => ['nullable', 'url', 'max:255'],
        ]);

        $student->update($validated);

        return new StudentResource($student->fresh());
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json(['message' => 'Student profile deleted successfully.']);
    }
}
