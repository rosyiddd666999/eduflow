<?php

namespace App\Filament\Guru\Resources\VideoResource\Pages;

use App\Filament\Guru\Resources\VideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideo extends EditRecord
{
    protected static string $resource = VideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
