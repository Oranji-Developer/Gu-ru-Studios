<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Course::all() as $course) {
            Schedule::factory()->create([
                'course_id' => $course->id,
                'total_meet' => $course->course_type === 'seni' ? 15 : 20,
            ]);
        }
    }
}
