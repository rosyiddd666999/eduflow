<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Admin EduFlow',
            'email' => 'admin@eduflow.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Teachers
        User::factory()->create([
            'name' => 'Teacher One',
            'email' => 'teacher1@eduflow.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
            'school_name' => 'SMA Negeri 1',
        ]);

        User::factory()->create([
            'name' => 'Teacher Two',
            'email' => 'teacher2@eduflow.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
            'school_name' => 'SMA Negeri 2',
        ]);

        // Students
        for ($i = 1; $i <= 6; $i++) {
            User::factory()->create([
                'name' => "Student $i",
                'email' => "student$i@eduflow.com",
                'password' => bcrypt('password'),
                'role' => 'student',
                'school_name' => ($i <= 3) ? 'SMA Negeri 1' : 'SMA Negeri 2',
            ]);
        }
    }
}
