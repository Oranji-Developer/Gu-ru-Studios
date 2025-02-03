<?php

namespace Database\Factories;

use App\Enum\Contents\ContentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
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
            'type' => $this->faker->randomElement(ContentType::getValues()),
            'link' => $this->faker->url,
        ];
    }
}
