<?php

namespace Database\Seeders;

use App\Models\Children;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChildrenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::where('role', 'customer')->get() as $user) {
            Children::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
