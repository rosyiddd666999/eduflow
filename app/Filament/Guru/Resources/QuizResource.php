<?php

namespace App\Filament\Guru\Resources;

use App\Filament\Guru\Resources\QuizResource\Pages;
use App\Filament\Guru\Resources\QuizResource\RelationManagers;
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('teacher_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Detail Kuis')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Judul Kuis')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('subject')
                                ->label('Mata Pelajaran')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Textarea::make('description')
                                ->label('Deskripsi')
                                ->maxLength(65535)
                                ->columnSpanFull(),
                            Forms\Components\TextInput::make('duration_minutes')
                                ->label('Durasi (Menit)')
                                ->required()
                                ->numeric()
                                ->suffix('menit'),
                            Forms\Components\Hidden::make('teacher_id')
                                ->default(auth()->id()),
                        ]),
                    Forms\Components\Wizard\Step::make('Soal')
                        ->schema([
                            Forms\Components\Repeater::make('questions')
                                ->relationship()
                                ->schema([
                                    Forms\Components\Textarea::make('question_text')
                                        ->required()
                                        ->columnSpanFull(),
                                    Forms\Components\TextInput::make('option_a')->required(),
                                    Forms\Components\TextInput::make('option_b')->required(),
                                    Forms\Components\TextInput::make('option_c')->required(),
                                    Forms\Components\TextInput::make('option_d')->required(),
                                    Forms\Components\Select::make('correct_answer')
                                        ->options([
                                            'A' => 'A',
                                            'B' => 'B',
                                            'C' => 'C',
                                            'D' => 'D',
                                        ])
                                        ->required(),
                                ])
                                ->columns(2)
                        ]),
                    Forms\Components\Wizard\Step::make('Tinjau')
                        ->schema([
                            Forms\Components\Placeholder::make('review')
                                ->content('Pastikan semua detail kuis dan soal sudah benar sebelum menyimpan.')
                        ]),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Kuis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Mata Pelajaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Durasi (Menit)')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\QuizResource\RelationManagers\QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'view' => Pages\ViewQuiz::route('/{record}'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }
}
