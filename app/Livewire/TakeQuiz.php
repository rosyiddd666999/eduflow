<?php

namespace App\Livewire;

use Livewire\Component;

class TakeQuiz extends Component
{
    public $quiz;
    public $questions;
    public $currentQuestionIndex = 0;
    public $answers = [];
    public $isFinished = false;
    public $score = 0;
    public $accuracy = 0;

    public function mount($quiz)
    {
        $this->quiz = $quiz;
        $this->questions = $quiz->questions;
        foreach ($this->questions as $index => $question) {
            $this->answers[$index] = null;
        }
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
        }
    }

    public function submitQuiz(\App\Services\QuizService $quizService)
    {
        $attempt = $quizService->grade($this->quiz, $this->answers, auth()->user());

        $this->score = $attempt->score;
        $this->accuracy = $attempt->accuracy;
        $this->isFinished = true;
    }

    public function render()
    {
        return view('livewire.take-quiz');
    }
}
