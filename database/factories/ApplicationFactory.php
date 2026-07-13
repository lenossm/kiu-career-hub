<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Student;
use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Application>
 */
class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'vacancy_id' => Vacancy::factory(),
            'cover_letter' => $this->faker->paragraphs(asText: true),
            'status' => $this->faker->randomElement(['pending', 'reviewed', 'accepted', 'rejected']),
        ];
    }
}

