<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;

class QuizService
{
    /**
     * Grade a quiz attempt and save the result.
     *
     * @param Quiz $quiz
     * @param array $answers User's answers keyed by question index or ID
     * @param User $student
     * @return QuizAttempt
     */
    public function grade(Quiz $quiz, array $answers, User $student): QuizAttempt
    {
        $questions = $quiz->questions;
        $correct = 0;

        foreach ($questions as $index => $question) {
            // Check if answer exists and matches the correct answer
            if (isset($answers[$index]) && $answers[$index] === $question->correct_answer) {
                $correct++;
            }
        }

        $total = $questions->count();
        $score = $total > 0 ? (int) round(($correct / $total) * 100) : 0;
        $accuracy = $total > 0 ? round(($correct / $total) * 100, 2) : 0;

        return QuizAttempt::create([
            'quiz_id'         => $quiz->id,
            'student_id'      => $student->id,
            'score'           => $score,
            'total_questions' => $total,
            'correct_answers' => $correct,
            'accuracy'        => $accuracy,
            'completed_at'    => now(),
        ]);
    }
}
