<?php

namespace Database\Factories;

use App\Enum\Courses\AcademicClass;
use App\Enum\Courses\ArtsClass;
use App\Enum\Courses\CourseType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
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
            'thumbnail' => 'default.png',
            'disc' => $this->faker->numberBetween(1, 100),
            'course_type' => $courseType = $this->faker->randomElement(CourseType::getValues()),
            'class' => $courseType === 'abk' ? null
                : ($courseType === 'akademik' ? $this->faker->randomElement(AcademicClass::getValues())
                    : $this->faker->randomElement(ArtsClass::getValues())),
            'start_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+2 month'),
        ];
    }
}
