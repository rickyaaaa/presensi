<?php

namespace App\Filament\Resources\JadwalModels\Pages;

use App\Filament\Resources\JadwalModels\JadwalModelResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditJadwalModel extends EditRecord
{
    protected static string $resource = JadwalModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
