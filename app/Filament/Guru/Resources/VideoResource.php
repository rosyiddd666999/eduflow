<?php

namespace App\Filament\Guru\Resources;

use App\Filament\Guru\Resources\VideoResource\Pages;
use App\Filament\Guru\Resources\VideoResource\RelationManagers;
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('teacher_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul Video')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->label('Tipe Video')
                    ->options([
                        'youtube' => 'YouTube',
                        'vimeo' => 'Vimeo',
                        'upload' => 'Upload File (.mp4)',
                    ])
                    ->required()
                    ->live()
                    ->default('youtube'),
                Forms\Components\TextInput::make('url')
                    ->label('Link Video')
                    ->url()
                    ->maxLength(255)
                    ->required(fn (Forms\Get $get) => in_array($get('type'), ['youtube', 'vimeo']))
                    ->visible(fn (Forms\Get $get) => in_array($get('type'), ['youtube', 'vimeo'])),
                Forms\Components\FileUpload::make('file_path')
                    ->label('File Video (.mp4)')
                    ->disk('public')
                    ->directory('videos')
                    ->acceptedFileTypes(['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/x-matroska'])
                    ->maxSize(102400) // 100MB max
                    ->helperText('Max 100MB. Jalankan server dengan: php -d upload_max_filesize=100M -d post_max_size=100M artisan serve')
                    ->required(fn (Forms\Get $get) => $get('type') === 'upload')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'upload')
                    ->saveUploadedFileUsing(function ($file) {
                        return app(\App\Services\CpanelUploadService::class)->upload($file);
                    }),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Hidden::make('teacher_id')
                    ->default(auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
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

    public static function infolist(\Filament\Infolists\Infolist $infolist): \Filament\Infolists\Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Video Details')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('title')
                            ->weight('bold')
                            ->size('lg'),
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
            'create' => Pages\CreateVideo::route('/create'),
            'view' => Pages\ViewVideo::route('/{record}'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
