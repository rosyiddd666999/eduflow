<?php

namespace App\Filament\Siswa\Resources\QuizResource\Pages;

use App\Filament\Siswa\Resources\QuizResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewQuiz extends ViewRecord
{
    protected static string $resource = QuizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
