<?php



namespace App\Http\Controllers;



use App\Models\Vacancy;

use App\Services\VacancyMatchService;

use Illuminate\Http\Request;



class StudentFeedController extends Controller

{

    public function index(Request $request)

    {

        $student = $request->user()->student;



        if (! $student) {

            return redirect()->route('my.profile.create');

        }



        $sort = $request->string('sort')->toString();

        if (! in_array($sort, ['recommended', 'deadline', 'newest'], true)) {

            $sort = 'recommended';

        }



        $vacanciesQuery = Vacancy::query()

            ->open()

            ->forStudents()

            ->when($request->filled('q'), function ($query) use ($request) {

                $q = $request->string('q')->toString();

                $query->where(function ($builder) use ($q) {

                    $builder

                        ->where('title', 'like', "%{$q}%")

                        ->orWhere('company', 'like', "%{$q}%")

                        ->orWhere('required_skills', 'like', "%{$q}%")

                        ->orWhere('description', 'like', "%{$q}%");

                });

            });



        if ($sort === 'deadline') {

            $vacanciesQuery->orderBy('deadline');

        } elseif ($sort === 'newest') {

            $vacanciesQuery->orderByDesc('id');

        } else {

            $vacanciesQuery->orderBy('deadline');

        }



        $vacancies = $vacanciesQuery->paginate(12)->withQueryString();



        if ($sort === 'recommended') {

            $ranked = VacancyMatchService::rankForStudent($student, $vacancies->getCollection());

            $vacancies->setCollection($ranked->pluck('vacancy'));

            $scores = $ranked->mapWithKeys(fn (array $item) => [$item['vacancy']->id => $item['score']]);

        } else {

            $scores = $vacancies->getCollection()->mapWithKeys(

                fn (Vacancy $vacancy) => [$vacancy->id => VacancyMatchService::score($student, $vacancy)]

            );

        }



        $appliedIds = $student->applications()->pluck('vacancy_id');



        return view('student.vacancies', [

            'student' => $student,

            'vacancies' => $vacancies,

            'scores' => $scores,

            'appliedIds' => $appliedIds,

            'q' => $request->string('q')->toString(),

            'sort' => $sort,

        ]);

    }



    public function show(Request $request, Vacancy $vacancy)

    {

        abort_unless($vacancy->isForStudents() && $vacancy->status === 'pending', 404);



        $student = $request->user()->student;



        if (! $student) {

            return redirect()->route('my.profile.create');

        }



        $score = VacancyMatchService::score($student, $vacancy);

        $hasApplied = $student->applications()->where('vacancy_id', $vacancy->id)->exists();



        return view('student.vacancy-show', [

            'student' => $student,

            'vacancy' => $vacancy,

            'score' => $score,

            'hasApplied' => $hasApplied,

        ]);

    }

}


