<?php

namespace App\Filament\Guru\Resources;

use App\Filament\Guru\Resources\QuizAttemptResource\Pages;
use App\Filament\Guru\Resources\QuizAttemptResource\RelationManagers;
use App\Models\QuizAttempt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizAttemptResource extends Resource
{
    protected static ?string $model = QuizAttempt::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Hasil Kuis';
    protected static ?string $pluralModelLabel = 'Hasil Kuis';
    protected static ?string $modelLabel = 'Hasil Kuis';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('quiz', function (Builder $query) {
            $query->where('teacher_id', auth()->id());
        });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'name')
                    ->label('Siswa'),
                Forms\Components\Select::make('quiz_id')
                    ->relationship('quiz', 'title')
                    ->label('Kuis'),
                Forms\Components\TextInput::make('score')
                    ->label('Skor')
                    ->numeric(),
                Forms\Components\TextInput::make('accuracy')
                    ->label('Akurasi (%)')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quiz.title')
                    ->label('Kuis')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Siswa')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('score')
                    ->label('Skor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('accuracy')
                    ->label('Akurasi')
                    ->formatStateUsing(fn($state) => $state . '%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dikerjakan pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('quiz_id')
                    ->relationship('quiz', 'title', fn(Builder $query) => $query->where('teacher_id', auth()->id()))
                    ->label('Filter Kuis'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // Read only
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
            'index' => Pages\ListQuizAttempts::route('/'),
            'view' => Pages\ViewQuizAttempt::route('/{record}'),
        ];
    }
}
