<?php

namespace App\Filament\Resources\SightResource\Pages;

use App\Filament\Resources\SightResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSight extends EditRecord
{
    protected static string $resource = SightResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
