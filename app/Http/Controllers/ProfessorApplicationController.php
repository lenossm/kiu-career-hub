<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfessorApplicationAdminRequest;
use App\Http\Requests\ProfessorApplicationRequest;
use App\Models\ProfessorApplication;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Storage;

class ProfessorApplicationController extends Controller
{
    public function create(Vacancy $vacancy)
    {
        abort_unless($vacancy->isForProfessors() && $vacancy->status === 'pending', 404);

        $professor = auth()->user()->professor;

        if (! $professor) {
            return redirect()->route('professor.profile.create');
        }

        return view('professor.apply', compact('vacancy', 'professor'));
    }

    public function store(ProfessorApplicationRequest $request, Vacancy $vacancy)
    {
        abort_unless($vacancy->isForProfessors(), 404);

        $professor = auth()->user()->professor;

        $data = [
            'professor_id' => $professor->id,
            'vacancy_id' => $vacancy->id,
            'cover_letter' => $request->validated('cover_letter'),
            'status' => 'pending',
        ];

        if ($request->hasFile('resume')) {
            $data['resume_path'] = $request->file('resume')->store('resumes', 'public');
        }

        ProfessorApplication::create($data);

        return redirect()
            ->route('professor.portal')
            ->with('success', 'Application submitted to KIU career office.');
    }

    public function show(ProfessorApplication $professorApplication)
    {
        $professorApplication->load(['professor', 'vacancy']);

        return view('professor-applications.show', [
            'application' => $professorApplication,
        ]);
    }

    public function edit(ProfessorApplication $professorApplication)
    {
        $professorApplication->load(['professor', 'vacancy']);

        return view('professor-applications.edit', [
            'application' => $professorApplication,
        ]);
    }

    public function update(ProfessorApplicationAdminRequest $request, ProfessorApplication $professorApplication)
    {
        $validated = $request->validated();

        $data = [
            'cover_letter' => $validated['cover_letter'],
            'status' => $validated['status'],
        ];

        if ($request->hasFile('resume')) {
            if ($professorApplication->resume_path) {
                Storage::disk('public')->delete($professorApplication->resume_path);
            }
            $data['resume_path'] = $request->file('resume')->store('resumes', 'public');
        }

        $professorApplication->update($data);

        return redirect()
            ->route('professor-applications.show', $professorApplication)
            ->with('success', 'Faculty application updated.');
    }

    public function destroy(ProfessorApplication $professorApplication)
    {
        if ($professorApplication->resume_path) {
            Storage::disk('public')->delete($professorApplication->resume_path);
        }

        $professorApplication->delete();

        return redirect()
            ->route('applications.index', ['tab' => 'faculty'])
            ->with('success', 'Faculty application deleted.');
    }
}
