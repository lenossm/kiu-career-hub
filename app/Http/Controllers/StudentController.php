<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();

        $studentsQuery = Student::query()->withCount('applications');

        if ($q !== '') {
            $studentsQuery->where(function ($query) use ($q) {
                $query
                    ->where('full_name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('faculty', 'like', "%{$q}%")
                    ->orWhere('skills', 'like', "%{$q}%");
            });
        }

        $students = $studentsQuery->orderByDesc('id')->paginate(12)->withQueryString();

        return view('students.index', compact('students', 'q'));
    }

    public function show(Student $student)
    {
        $student->load(['applications.vacancy', 'user']);

        return view('students.show', compact('student'));
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student profile removed.');
    }
}
