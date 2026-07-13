<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'faculty' => $this->faker->randomElement(['Computer Science', 'Management', 'Mathematics']),
            'short_bio' => $this->faker->paragraph(),
            'skills' => implode(', ', $this->faker->words(8)),
            'experience' => $this->faker->optional()->paragraphs(asText: true),
            'portfolio_link' => $this->faker->optional()->url(),
            'github_link' => $this->faker->optional()->url(),
            'linkedin_link' => $this->faker->optional()->url(),
        ];
    }
}

