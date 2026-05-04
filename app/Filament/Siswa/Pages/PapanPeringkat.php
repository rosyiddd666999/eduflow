<?php

namespace App\Filament\Siswa\Pages;

use Filament\Pages\Page;

class PapanPeringkat extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.siswa.pages.papan-peringkat';

    protected function getViewData(): array
    {
        $leaderboard = \Illuminate\Support\Facades\DB::table('quiz_attempts')
            ->join('users', 'users.id', '=', 'quiz_attempts.student_id')
            ->select(
                'users.name',
                'users.school_name',
                \Illuminate\Support\Facades\DB::raw('SUM(score) as total_points'),
                \Illuminate\Support\Facades\DB::raw('COUNT(*) as total_quizzes'),
                \Illuminate\Support\Facades\DB::raw('AVG(accuracy) as avg_accuracy')
            )
            ->groupBy('quiz_attempts.student_id', 'users.name', 'users.school_name')
            ->orderByDesc('total_points')
            ->get();

        return [
            'topStudents' => $leaderboard->take(3),
            'otherStudents' => $leaderboard->skip(3), //!Bisa/berpotensi menjadi bug
        ];
    }
}
