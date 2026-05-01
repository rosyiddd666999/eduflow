<?php

namespace App\Filament\Siswa\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ScoreHistory extends BaseWidget
{
    protected static ?string $heading = 'Riwayat Kuis';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\QuizAttempt::where('user_id', auth()->id())->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('quiz.title')
                    ->label('Kuis'),
                Tables\Columns\TextColumn::make('score')
                    ->label('Skor')
                    ->badge()
                    ->color(fn (float $state): string => $state >= 70 ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('accuracy')
                    ->label('Akurasi')
                    ->suffix('%'),
                Tables\Columns\TextColumn::make('completed_at')
                    ->label('Waktu Selesai')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}
