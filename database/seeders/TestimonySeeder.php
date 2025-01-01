<?php

namespace Database\Seeders;

use App\Models\Testimonies;
use App\Models\UserCourse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (UserCourse::all() as $userCourse) {
            Testimonies::factory()->create([
                'userCourse_id' => $userCourse->id,
            ]);
        }
    }
}
