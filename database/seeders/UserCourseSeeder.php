<?php

namespace Database\Seeders;

use App\Models\Children;
use App\Models\UserCourse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Children::all() as $children) {
            UserCourse::factory()->create([
                'children_id' => $children->id,
            ]);
        }
    }
}
