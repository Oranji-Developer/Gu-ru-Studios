<?php

namespace Database\Factories;

use App\Enum\Courses\CourseType;
use App\Enum\Courses\StatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'desc' => $this->faker->paragraph(),
            'cost' => $this->faker->numberBetween(1000, 10000),
            'capacity' => $this->faker->numberBetween(1, 100),
            'thumbnail' => 'default.png',
            'status' => $this->faker->randomElement(StatusEnum::getValues()),
        ];
    }
}
