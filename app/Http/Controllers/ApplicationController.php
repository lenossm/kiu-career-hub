<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use App\Models\ProfessorApplication;
use App\Models\Student;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::query()
            ->with(['student', 'vacancy'])
            ->orderByDesc('id')
            ->paginate(12);

        $professorApplications = ProfessorApplication::query()
            ->with(['professor', 'vacancy'])
            ->orderByDesc('id')
            ->paginate(12, ['*'], 'prof_page');

        return view('applications.index', [
            'applications' => $applications,
            'professorApplications' => $professorApplications,
        ]);
    }

    public function show(Application $application)
    {
        $application->load(['student', 'vacancy']);

        return view('applications.show', ['application' => $application]);
    }

    /** Admin: record application on behalf of a student */
    public function create(Vacancy $vacancy)
    {
        abort_unless($vacancy->isForStudents(), 404);

        $students = Student::query()->orderBy('full_name')->get();

        return view('applications.create', compact('vacancy', 'students'));
    }

    public function store(ApplicationRequest $request, Vacancy $vacancy)
    {
        abort_unless($vacancy->isForStudents(), 404);

        $validated = $request->validated();

        $data = [
            'student_id' => $validated['student_id'],
            'vacancy_id' => $vacancy->id,
            'cover_letter' => $validated['cover_letter'],
            'status' => 'pending',
        ];

        if ($request->hasFile('resume')) {
            $data['resume_path'] = $request->file('resume')->store('resumes', 'public');
        }

        Application::create($data);

        return redirect()
            ->route('applications.index')
            ->with('success', 'Application recorded successfully.');
    }

    /** Student: apply with own profile */
    public function studentCreate(Vacancy $vacancy)
    {
        abort_unless($vacancy->isForStudents() && $vacancy->status === 'pending', 404);

        $student = auth()->user()->student;

        if (! $student) {
            return redirect()->route('my.profile.create');
        }

        if ($student->applications()->where('vacancy_id', $vacancy->id)->exists()) {
            return redirect()->route('student.vacancies.index')->with('error', 'You already applied to this vacancy.');
        }

        return view('student.apply', compact('vacancy', 'student'));
    }

    public function studentStore(ApplicationRequest $request, Vacancy $vacancy)
    {
        abort_unless($vacancy->isForStudents(), 404);

        $student = auth()->user()->student;

        $data = [
            'student_id' => $student->id,
            'vacancy_id' => $vacancy->id,
            'cover_letter' => $request->validated('cover_letter'),
            'status' => 'pending',
        ];

        if ($request->hasFile('resume')) {
            $data['resume_path'] = $request->file('resume')->store('resumes', 'public');
        }

        Application::create($data);

        return redirect()
            ->route('student.vacancies.index')
            ->with('success', 'Application sent! Career office will review it soon.');
    }

    public function edit(Application $application)
    {
        $application->load(['student', 'vacancy']);

        return view('applications.edit', compact('application'));
    }

    public function update(ApplicationRequest $request, Application $application)
    {
        $validated = $request->validated();

        $data = [
            'cover_letter' => $validated['cover_letter'],
            'status' => $validated['status'] ?? $application->status,
        ];

        if ($request->hasFile('resume')) {
            if ($application->resume_path) {
                Storage::disk('public')->delete($application->resume_path);
            }
            $data['resume_path'] = $request->file('resume')->store('resumes', 'public');
        }

        $application->update($data);

        return redirect()
            ->route('applications.show', $application)
            ->with('success', 'Application updated successfully.');
    }

    public function destroy(Application $application)
    {
        if ($application->resume_path) {
            Storage::disk('public')->delete($application->resume_path);
        }

        $application->delete();

        return redirect()
            ->route('applications.index')
            ->with('success', 'Application deleted successfully.');
    }
}
