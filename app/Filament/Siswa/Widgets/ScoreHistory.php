<?php

namespace App\Filament\Siswa\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ScoreHistory extends BaseWidget
{
    protected static ?string $heading = 'Riwayat Kuis';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\QuizAttempt::where('student_id', auth()->id())->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('quiz.title')
                    ->label('Kuis')
                    ->description(fn($record) => $record->quiz->teacher->name ?? 'EduFlow Guru')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('score')
                    ->label('Skor')
                    ->badge()
                    ->color(fn(float $state): string => $state >= 70 ? 'success' : 'danger')
                    ->suffix(' Poin')
                    ->sortable(),
                Tables\Columns\TextColumn::make('accuracy')
                    ->label('Akurasi')
                    ->numeric(1)
                    ->suffix('%')
                    ->color('primary')
                    ->icon('heroicon-m-academic-cap'),
                Tables\Columns\TextColumn::make('completed_at')
                    ->label('Tanggal Selesai')
                    ->dateTime('d M Y, H:i')
                    ->color('gray')
                    ->sortable(),
            ])
            ->defaultSort('completed_at', 'desc')
            ->emptyStateHeading('Belum ada riwayat kuis')
            ->emptyStateDescription('Mulai belajar dengan mengerjakan kuis yang tersedia!')
            ->emptyStateIcon('heroicon-o-clipboard-document-list');
    }
}
