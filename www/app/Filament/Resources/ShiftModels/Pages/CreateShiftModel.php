<?php

namespace App\Filament\Resources\ShiftModels\Pages;

use App\Filament\Resources\ShiftModels\ShiftModelResource;
use Filament\Resources\Pages\CreateRecord;

class CreateShiftModel extends CreateRecord
{
    protected static string $resource = ShiftModelResource::class;
    protected static ?string $title = 'Add New Shift';

}
