<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Guru', \App\Models\User::where('role', 'teacher')->count())
                ->description('Guru terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),
            Stat::make('Total Siswa', \App\Models\User::where('role', 'student')->count())
                ->description('Siswa terdaftar')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),
            Stat::make('Total Kuis', \App\Models\Quiz::count())
                ->description('Kuis tersedia')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),
        ];
    }
}
