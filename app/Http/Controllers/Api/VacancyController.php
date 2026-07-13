<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VacancyResource;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VacancyController extends Controller
{
    public function index(Request $request)
    {
        $query = Vacancy::query()->withCount('applications');

        if ($request->filled('status') && in_array($request->status, ['pending', 'done'], true)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($builder) use ($q) {
                $builder
                    ->where('title', 'like', "%{$q}%")
                    ->orWhere('company', 'like', "%{$q}%");
            });
        }

        return VacancyResource::collection(
            $query->orderByDesc('id')->paginate(10)
        );
    }

    public function show(Vacancy $vacancy)
    {
        $vacancy->loadCount('applications');

        return new VacancyResource($vacancy);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'required_skills' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'deadline' => ['required', 'date'],
            'status' => ['nullable', Rule::in(['pending', 'done'])],
        ]);

        $validated['status'] = $validated['status'] ?? 'pending';

        return (new VacancyResource(Vacancy::create($validated)))
            ->response()
            ->setStatusCode(201);
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'company' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string'],
            'required_skills' => ['sometimes', 'required', 'string'],
            'location' => ['sometimes', 'required', 'string', 'max:255'],
            'type' => ['sometimes', 'required', 'string', 'max:255'],
            'deadline' => ['sometimes', 'required', 'date'],
            'status' => ['sometimes', Rule::in(['pending', 'done'])],
        ]);

        $vacancy->update($validated);

        return new VacancyResource($vacancy->fresh());
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();

        return response()->json(['message' => 'Vacancy deleted successfully.']);
    }
}
