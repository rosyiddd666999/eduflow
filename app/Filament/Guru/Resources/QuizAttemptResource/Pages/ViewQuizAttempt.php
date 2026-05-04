<?php

namespace App\Filament\Guru\Resources\QuizAttemptResource\Pages;

use App\Filament\Guru\Resources\QuizAttemptResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewQuizAttempt extends ViewRecord
{
    protected static string $resource = QuizAttemptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
