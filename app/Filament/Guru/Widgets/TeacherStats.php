<?php

namespace App\Filament\Guru\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TeacherStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Kuis Saya', \App\Models\Quiz::where('teacher_id', auth()->id())->count())
                ->description('Total kuis yang dibuat')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),
            Stat::make('Video Saya', \App\Models\Video::where('teacher_id', auth()->id())->count())
                ->description('Total video yang diunggah')
                ->descriptionIcon('heroicon-m-video-camera')
                ->color('success'),
            Stat::make('Total Pengerjaan', \App\Models\QuizAttempt::whereIn('quiz_id', \App\Models\Quiz::where('teacher_id', auth()->id())->pluck('id'))->count())
                ->description('Total kuis yang dikerjakan siswa')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info'),
        ];
    }
}
