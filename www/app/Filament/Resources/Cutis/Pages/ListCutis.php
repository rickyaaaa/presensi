<?php

namespace App\Filament\Resources\Cutis\Pages;

use App\Filament\Resources\Cutis\CutisResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCutis extends ListRecords
{
    protected static string $resource = CutisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
