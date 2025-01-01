<?php

namespace Database\Factories;

use App\Enum\Courses\CourseType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mentor>
 */
class MentorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'desc' => $this->faker->paragraph(),
            'profile_picture' => 'default.png',
            'cv' => 'default.pdf',
            'portfolio' => 'default.pdf',
            'field' => $this->faker->randomElement(CourseType::getValues())
        ];
    }
}
