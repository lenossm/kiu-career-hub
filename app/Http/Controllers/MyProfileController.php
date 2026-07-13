<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MyProfileController extends Controller
{
    public function create()
    {
        if (auth()->user()->student) {
            return redirect()->route('my.profile.edit');
        }

        return view('student.profile-create', [
            'student' => new Student([
                'full_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ]),
        ]);
    }

    public function store(StudentRequest $request)
    {
        if (auth()->user()->student) {
            return redirect()->route('my.profile.edit');
        }

        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('photos', 'public');
        }

        unset($validated['photo']);

        Student::create($validated);

        return redirect()
            ->route('student.vacancies.index')
            ->with('success', 'Profile created. You can now browse and apply to opportunities.');
    }

    public function edit()
    {
        $student = auth()->user()->student;

        if (! $student) {
            return redirect()->route('my.profile.create');
        }

        return view('student.profile-edit', compact('student'));
    }

    public function update(StudentRequest $request)
    {
        $student = auth()->user()->student;

        if (! $student) {
            return redirect()->route('my.profile.create');
        }

        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            if ($student->photo_path) {
                Storage::disk('public')->delete($student->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('photos', 'public');
        }

        unset($validated['photo']);

        $student->update($validated);

        return redirect()
            ->route('student.vacancies.index')
            ->with('success', 'Profile updated.');
    }

    public function show()
    {
        $student = auth()->user()->student;

        if (! $student) {
            return redirect()->route('my.profile.create');
        }

        $student->load(['applications.vacancy']);

        return view('student.profile-show', compact('student'));
    }
}
