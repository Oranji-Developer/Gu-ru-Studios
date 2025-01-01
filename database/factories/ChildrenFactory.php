<?php

namespace Database\Factories;

use App\Enum\Courses\AcademicClass;
use App\Enum\Users\GenderEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Children>
 */
class ChildrenFactory extends Factory
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
            'class' => $this->faker->randomElement(AcademicClass::getValues()),
            'gender' => $this->faker->randomElement(GenderEnum::getValues()),
        ];
    }
}
