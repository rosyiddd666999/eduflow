<?php

namespace App\Filament\Siswa\Resources;

use App\Filament\Siswa\Resources\VideoResource\Pages;
use App\Filament\Siswa\Resources\VideoResource\RelationManagers;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Read-only view will use Infolists instead
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Guru')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'youtube' => 'danger',
                        'vimeo' => 'info',
                        'upload' => 'success',
                        default => 'primary',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function infolist(\Filament\Infolists\Infolist $infolist): \Filament\Infolists\Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Informasi Video')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('title')
                            ->weight(\Filament\Support\Enums\FontWeight::Bold)
                            ->size(\Filament\Infolists\Components\TextEntry\TextEntrySize::Large),
                        \Filament\Infolists\Components\TextEntry::make('teacher.name')
                            ->label('Oleh Guru'),
                        \Filament\Infolists\Components\TextEntry::make('description')
                            ->markdown()
                            ->columnSpanFull(),
                        \Filament\Infolists\Components\ViewEntry::make('url')
                            ->label('Video Player')
                            ->view('filament.components.video-embed')
                            ->columnSpanFull(),
                        \Filament\Infolists\Components\TextEntry::make('url')
                            ->label('Link Sumber')
                            ->url(fn ($record) => $record->url)
                            ->color('primary')
                            ->visible(fn ($record) => $record->type !== 'upload')
                            ->columnSpanFull(),
                    ])->columns(2)
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
            'index' => Pages\ListVideos::route('/'),
            'view' => Pages\ViewVideo::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
