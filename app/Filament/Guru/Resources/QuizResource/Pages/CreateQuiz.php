<?php

namespace App\Filament\Guru\Resources\QuizResource\Pages;

use App\Filament\Guru\Resources\QuizResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQuiz extends CreateRecord
{
    protected static string $resource = QuizResource::class;
}
