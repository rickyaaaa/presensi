<?php

namespace App\Filament\Resources\KehadiranModels\Pages;

use App\Filament\Resources\KehadiranModels\KehadiranModelResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditKehadiranModel extends EditRecord
{
    protected static string $resource = KehadiranModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
