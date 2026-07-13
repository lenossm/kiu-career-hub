<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacancyRequest;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public const ALLOWED_TYPES = ['Internship', 'Part-time', 'Full-time', 'Remote'];

    public function index(Request $request)
    {
        $status = $request->string('status')->toString();
        $q = $request->string('q')->toString();
        $type = $request->string('type')->toString();
        $audience = $request->string('audience')->toString();

        $vacanciesQuery = Vacancy::query();

        if (in_array($audience, [Vacancy::AUDIENCE_STUDENT, Vacancy::AUDIENCE_PROFESSOR], true)) {
            $vacanciesQuery->where('audience', $audience);
        }

        if (in_array($status, ['pending', 'done'], true)) {
            $vacanciesQuery->where('status', $status);
        }

        if (in_array($type, self::ALLOWED_TYPES, true)) {
            $vacanciesQuery->where('type', $type);
        }

        if ($q !== '') {
            $vacanciesQuery->where(function ($query) use ($q) {
                $query
                    ->where('title', 'like', "%{$q}%")
                    ->orWhere('company', 'like', "%{$q}%")
                    ->orWhere('required_skills', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%");
            });
        }

        $vacancies = $vacanciesQuery
            ->orderBy('deadline')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        return view('vacancies.index', [
            'vacancies' => $vacancies,
            'status' => $status,
            'q' => $q,
            'type' => $type,
            'audience' => $audience,
            'allowedTypes' => self::ALLOWED_TYPES,
        ]);
    }

    public function create(Request $request)
    {
        $audience = $request->string('audience')->toString();
        $defaultAudience = in_array($audience, [Vacancy::AUDIENCE_STUDENT, Vacancy::AUDIENCE_PROFESSOR], true)
            ? $audience
            : Vacancy::AUDIENCE_STUDENT;

        return view('vacancies.create', [
            'vacancy' => new Vacancy([
                'status' => 'pending',
                'audience' => $defaultAudience,
            ]),
        ]);
    }

    public function store(VacancyRequest $request)
    {
        $validated = $request->validated();
        $validated['status'] = $validated['status'] ?? 'pending';

        $vacancy = Vacancy::create($validated);

        return redirect()
            ->route('vacancies.show', $vacancy)
            ->with('success', 'Vacancy created successfully.');
    }

    public function show(Vacancy $vacancy)
    {
        $vacancy->load(['applications.student', 'students']);

        return view('vacancies.show', [
            'vacancy' => $vacancy,
        ]);
    }

    public function edit(Vacancy $vacancy)
    {
        return view('vacancies.edit', [
            'vacancy' => $vacancy,
        ]);
    }

    public function update(VacancyRequest $request, Vacancy $vacancy)
    {
        $vacancy->update($request->validated());

        return redirect()
            ->route('vacancies.show', $vacancy)
            ->with('success', 'Vacancy updated successfully.');
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();

        return redirect()
            ->route('vacancies.index')
            ->with('success', 'Vacancy deleted successfully.');
    }

    public function toggleStatus(Vacancy $vacancy)
    {
        $vacancy->update([
            'status' => $vacancy->status === 'done' ? 'pending' : 'done',
        ]);

        if (request()->expectsJson()) {
            return response()->json([
                'id' => $vacancy->id,
                'status' => $vacancy->status,
                'deadline' => $vacancy->deadline->format('Y-m-d'),
            ]);
        }

        return back()->with('success', 'Vacancy status updated.');
    }
}
