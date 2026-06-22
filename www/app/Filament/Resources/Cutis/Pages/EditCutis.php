<?php

namespace App\Filament\Resources\Cutis\Pages;

use App\Filament\Resources\Cutis\CutisResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCutis extends EditRecord
{
    protected static string $resource = CutisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
