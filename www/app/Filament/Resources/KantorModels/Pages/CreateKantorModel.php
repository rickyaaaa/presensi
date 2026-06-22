<?php

namespace App\Filament\Resources\KantorModels\Pages;

use App\Filament\Resources\KantorModels\KantorModelResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKantorModel extends CreateRecord
{
    protected static string $resource = KantorModelResource::class;
    protected static ?string $title = 'Tambah Kantor Baru';
}
