<?php

namespace App\Filament\Siswa\Pages;

use Filament\Pages\Page;

class TakeQuiz extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.siswa.pages.take-quiz';

    public $quiz;

    public function mount()
    {
        $quizId = request()->query('quiz');
        $this->quiz = \App\Models\Quiz::with('questions')->findOrFail($quizId);
    }
}
