<?php

namespace App\Filament\Siswa\Resources;

use App\Filament\Siswa\Resources\QuizResource\Pages;
use App\Filament\Siswa\Resources\QuizResource\RelationManagers;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration')
                    ->suffix(' menit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Guru'),
                Tables\Columns\TextColumn::make('questions_count')
                    ->counts('questions')
                    ->label('Total Soal'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('takeQuiz')
                    ->label('Mulai Kuis')
                    ->color('success')
                    ->icon('heroicon-o-play')
                    ->url(fn ($record) => \App\Filament\Siswa\Pages\TakeQuiz::getUrl(['quiz' => $record->id])),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
