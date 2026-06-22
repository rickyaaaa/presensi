<?php

namespace App\Filament\Resources\ShiftModels\Pages;

use App\Filament\Resources\ShiftModels\ShiftModelResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditShiftModel extends EditRecord
{
    protected static string $resource = ShiftModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
