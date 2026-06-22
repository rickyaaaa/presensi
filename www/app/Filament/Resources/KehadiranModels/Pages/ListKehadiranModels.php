<?php

namespace App\Filament\Resources\KehadiranModels\Pages;

use App\Filament\Resources\KehadiranModels\KehadiranModelResource;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListKehadiranModels extends ListRecords
{
    protected static string $resource = KehadiranModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('Unduh Kehadiran')
                ->url(route('KehadiranModels.export'))
                ->color('danger'),
            Action::make('Tambah Presensi')
                ->url(route('presensi'))
                ->color('success'),
        ];
    }
}
