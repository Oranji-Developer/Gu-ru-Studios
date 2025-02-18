<?php

namespace Database\Seeders;

use App\Enum\Users\RoleEnum;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use http\Env;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        if (env('APP_TESTING')) {
        User::factory()->create([
            'name' => 'Admin1',
            'email' => 'test@gmail.com',
            'password' => Hash::make(config('app.prod.app_pw')),
            'role' => RoleEnum::ADMIN->value,
            'phone' => '081234567890',
            'address' => 'Jl. Test No. 1',
            'email_verified_at' => now(),
        ]);

//        } else {
//            $this->call([
//                UserSeeder::class,q
//                EventSeeder::class,
//                ContentSeeder::class,
//                MentorSeeder::class,
//                CourseSeeder::class,
//                ScheduleSeeder::class,
//                ChildrenSeeder::class,
//                UserCourseSeeder::class,
//                TestimonySeeder::class,
//            ]);
//        }
    }
}
