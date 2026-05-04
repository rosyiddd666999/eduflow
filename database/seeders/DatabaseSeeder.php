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
        $students = [];
        for ($i = 1; $i <= 6; $i++) {
            $students[] = User::factory()->create([
                'name' => "Student $i",
                'email' => "student$i@eduflow.com",
                'password' => bcrypt('password'),
                'role' => 'student',
                'school_name' => ($i <= 3) ? 'SMA Negeri 1' : 'SMA Negeri 2',
            ]);
        }

        // Mock Quizzes
        $teacher1 = User::where('email', 'teacher1@eduflow.com')->first();
        $quiz1 = \App\Models\Quiz::create([
            'teacher_id' => $teacher1->id,
            'title' => 'Kuis Matematika Dasar',
            'subject' => 'Matematika',
            'description' => 'Kuis tentang aljabar dasar.',
            'duration_minutes' => 30,
        ]);

        $quiz2 = \App\Models\Quiz::create([
            'teacher_id' => $teacher1->id,
            'title' => 'Kuis Fisika Dasar',
            'subject' => 'Fisika',
            'description' => 'Kuis tentang kinematika.',
            'duration_minutes' => 45,
        ]);

        // Mock Questions
        \App\Models\Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Berapa 1 + 1?',
            'option_a' => '1',
            'option_b' => '2',
            'option_c' => '3',
            'option_d' => '4',
            'correct_answer' => 'B',
        ]);

        \App\Models\Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Berapa 2 x 3?',
            'option_a' => '4',
            'option_b' => '5',
            'option_c' => '6',
            'option_d' => '7',
            'correct_answer' => 'C',
        ]);

        // Mock Quiz Attempts for Leaderboard
        $scores = [100, 80, 50, 90, 60, 40];
        $accuracies = [100, 80, 50, 90, 60, 40];

        foreach ($students as $index => $student) {
            \App\Models\QuizAttempt::create([
                'quiz_id' => $quiz1->id,
                'student_id' => $student->id,
                'score' => $scores[$index],
                'total_questions' => 2,
                'correct_answers' => round($accuracies[$index] / 50), // 100=2, 80=1.6~2, 50=1
                'accuracy' => $accuracies[$index],
                'completed_at' => now()->subHours(1),
            ]);

            // Give some students a second attempt on quiz 2
            if ($index % 2 == 0) {
                \App\Models\QuizAttempt::create([
                    'quiz_id' => $quiz2->id,
                    'student_id' => $student->id,
                    'score' => $scores[5 - $index] + 10,
                    'total_questions' => 2,
                    'correct_answers' => round(($accuracies[5 - $index] + 10) / 50),
                    'accuracy' => $accuracies[5 - $index] + 10,
                    'completed_at' => now(),
                ]);
            }
        }
    }
}
