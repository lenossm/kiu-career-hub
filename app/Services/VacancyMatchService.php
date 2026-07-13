<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Vacancy;
use Illuminate\Support\Collection;

class VacancyMatchService
{
    public static function score(Student $student, Vacancy $vacancy): int
    {
        // skills arrive as comma-separated text from the form — normalize before comparing
        $studentSkills = self::normalizeSkills($student->skills);
        $requiredSkills = self::normalizeSkills($vacancy->required_skills);

        if ($requiredSkills->isEmpty()) {
            return 0;
        }

        $matches = $requiredSkills->filter(function (string $required) use ($studentSkills) {
            // partial match is fine — "laravel" should hit "php laravel mysql" style lists
            return $studentSkills->contains(function (string $skill) use ($required) {
                return $skill === $required
                    || str_contains($required, $skill)
                    || str_contains($skill, $required);
            });
        });

        return (int) round(($matches->count() / $requiredSkills->count()) * 100);
    }

  /**
     * @return Collection<int, array{vacancy: Vacancy, score: int}>
     */
    public static function rankForStudent(Student $student, Collection $vacancies): Collection
    {
        return $vacancies
            ->map(fn (Vacancy $vacancy) => [
                'vacancy' => $vacancy,
                'score' => self::score($student, $vacancy),
            ])
            ->sortByDesc('score')
            ->values();
    }

    private static function normalizeSkills(?string $skills): Collection
    {
        return collect(preg_split('/[,;|]+/', strtolower((string) $skills)))
            ->map(fn (string $skill) => trim($skill))
            ->filter();
    }
}
