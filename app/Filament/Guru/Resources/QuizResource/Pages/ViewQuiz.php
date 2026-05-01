<?php

namespace App\Filament\Guru\Resources\QuizResource\Pages;

use App\Filament\Guru\Resources\QuizResource;
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
