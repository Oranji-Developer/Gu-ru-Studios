<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->date();
        $endDate = $this->faker->dateTimeBetween($startDate, '+1 month')->format('Y-m-d');
        $startTime = $this->faker->time();
        $endTime = $this->faker->time('H:i:s', strtotime($startTime) + rand(3600, 86400));

        return [
            'day' => $this->faker->randomElement(['Senin, Selasa, Rabu', 'Kamis, Jumat, Sabtu', 'Senin,Kamis', 'Selasa, Jumat']),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
