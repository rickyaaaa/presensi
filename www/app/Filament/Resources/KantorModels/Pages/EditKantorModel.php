<?php

namespace App\Filament\Resources\KantorModels\Pages;

use App\Filament\Resources\KantorModels\KantorModelResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditKantorModel extends EditRecord
{
    protected static string $resource = KantorModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
