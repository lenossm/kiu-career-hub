<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfessorProfileRequest;
use App\Models\Professor;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfessorPortalController extends Controller
{
    public function index(Request $request)
    {
        $professor = $request->user()->professor;

        if (! $professor) {
            return redirect()->route('professor.profile.create');
        }

        $vacancies = Vacancy::query()
            ->open()
            ->forProfessors()
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = $request->string('q')->toString();
                $query->where(function ($builder) use ($q) {
                    $builder
                        ->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->orderBy('deadline')
            ->paginate(9)
            ->withQueryString();

        $appliedIds = $professor->applications()->pluck('vacancy_id');

        return view('professor.portal', [
            'professor' => $professor,
            'vacancies' => $vacancies,
            'appliedIds' => $appliedIds,
            'q' => $request->string('q')->toString(),
        ]);
    }

    public function showVacancy(Vacancy $vacancy)
    {
        abort_unless($vacancy->isForProfessors() && $vacancy->status === 'pending', 404);

        $professor = auth()->user()->professor;

        if (! $professor) {
            return redirect()->route('professor.profile.create');
        }

        $hasApplied = $professor->applications()->where('vacancy_id', $vacancy->id)->exists();

        return view('professor.vacancy-show', [
            'professor' => $professor,
            'vacancy' => $vacancy,
            'hasApplied' => $hasApplied,
        ]);
    }

    public function createProfile()
    {
        if (auth()->user()->professor) {
            return redirect()->route('professor.profile.edit');
        }

        return view('professor.profile-create', [
            'professor' => new Professor([
                'full_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ]),
        ]);
    }

    public function storeProfile(ProfessorProfileRequest $request)
    {
        if (auth()->user()->professor) {
            return redirect()->route('professor.profile.edit');
        }

        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('photos', 'public');
        }

        unset($validated['photo']);

        Professor::create($validated);

        return redirect()
            ->route('professor.portal')
            ->with('success', 'Faculty profile ready. Browse internal KIU opportunities.');
    }

    public function editProfile()
    {
        $professor = auth()->user()->professor;

        if (! $professor) {
            return redirect()->route('professor.profile.create');
        }

        return view('professor.profile-edit', compact('professor'));
    }

    public function updateProfile(ProfessorProfileRequest $request)
    {
        $professor = auth()->user()->professor;

        if (! $professor) {
            return redirect()->route('professor.profile.create');
        }

        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            if ($professor->photo_path) {
                Storage::disk('public')->delete($professor->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('photos', 'public');
        }

        unset($validated['photo']);

        $professor->update($validated);

        return redirect()
            ->route('professor.portal')
            ->with('success', 'Profile updated.');
    }
}
