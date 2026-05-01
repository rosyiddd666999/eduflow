<?php

namespace App\Filament\Siswa\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentStats extends BaseWidget
{
    protected function getStats(): array
    {
        $attempts = \App\Models\QuizAttempt::where('user_id', auth()->id())->get();
        $avgScore = $attempts->avg('score') ?? 0;
        $totalQuizzes = $attempts->count();

        return [
            Stat::make('Rata-rata Skor', round($avgScore))
                ->description('Skor rata-rata Anda')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('indigo'),
            Stat::make('Kuis Selesai', $totalQuizzes)
                ->description('Total kuis yang telah dikerjakan')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
            Stat::make('Peringkat', '-')
                ->description('Peringkat Anda di sekolah')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('warning'),
        ];
    }
}
