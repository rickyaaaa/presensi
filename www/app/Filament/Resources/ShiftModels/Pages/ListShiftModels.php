<?php

namespace App\Filament\Resources\ShiftModels\Pages;

use App\Filament\Resources\ShiftModels\ShiftModelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListShiftModels extends ListRecords
{
    protected static string $resource = ShiftModelResource::class;
    protected static null|string $title = 'Halaman Shift';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Shift Baru'),
        ];
    }

}
