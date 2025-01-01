<?php

namespace Database\Seeders;

use App\Enum\Courses\AcademicClass;
use App\Enum\Courses\ArtsClass;
use App\Enum\Courses\CourseType;
use App\Models\Course;
use App\Models\Mentor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Mentor::all() as $mentor) {
            Course::factory()->create([
                'mentor_id' => $mentor->id,
                'course_type' => $mentor->field,
                'class' => $mentor->field === 'abk' ? null
                    : ($mentor->field === 'akademik' ? fake()->randomElement(AcademicClass::getValues())
                        : fake()->randomElement(ArtsClass::getValues())),
                'capacity' => $mentor->field === 'abk' ? 0 : fake()->numberBetween(1, 10),
            ]);
        }
    }
}
