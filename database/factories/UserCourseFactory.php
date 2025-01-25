<?php

namespace Database\Factories;

use App\Enum\Users\StatusEnum;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $course = Course::pluck('id')->toArray();

        return [
            'course_id' => $this->faker->randomElement($course),
            'start_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+2 month'),
            'status' => $this->faker->randomElement(StatusEnum::getValues()),
        ];
    }
}
