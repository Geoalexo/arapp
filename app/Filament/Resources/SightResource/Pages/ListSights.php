<?php

namespace App\Filament\Resources\SightResource\Pages;

use App\Filament\Resources\SightResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSights extends ListRecords
{
    protected static string $resource = SightResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
