<?php

namespace App\Filament\Resources\KantorModels\Pages;

use App\Filament\Resources\KantorModels\KantorModelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKantorModels extends ListRecords
{
    protected static string $resource = KantorModelResource::class;
    protected static null|string $title = 'Halaman Kantor';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Kantor Baru'),
        ];
    }
}
