<?php

namespace Database\Factories;

use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vacancy>
 */
class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'company' => $this->faker->company(),
            'description' => $this->faker->paragraphs(asText: true),
            'required_skills' => implode(', ', $this->faker->words(6)),
            'location' => $this->faker->randomElement(['Tbilisi', 'Kutaisi', 'Remote', 'Hybrid']),
            'type' => $this->faker->randomElement(['Internship', 'Part-time', 'Full-time', 'Remote']),
            'status' => $this->faker->randomElement(['pending', 'done']),
            'deadline' => $this->faker->dateTimeBetween('now', '+45 days')->format('Y-m-d'),
        ];
    }
}
