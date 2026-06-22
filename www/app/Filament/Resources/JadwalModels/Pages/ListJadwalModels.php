<?php

namespace App\Filament\Resources\JadwalModels\Pages;

use App\Filament\Resources\JadwalModels\JadwalModelResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJadwalModels extends ListRecords
{
    protected static string $resource = JadwalModelResource::class;
    protected static null|string $title = 'Halaman Jadwal';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Presensi')
                ->url(route('presensi'))
                ->color('success'),
            CreateAction::make()
                ->label('Tambah Jadwal Baru'),
        ];
    }
}
