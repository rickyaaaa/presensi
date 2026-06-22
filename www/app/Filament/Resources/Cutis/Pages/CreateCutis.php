<?php

namespace App\Filament\Resources\Cutis\Pages;

use App\Filament\Resources\Cutis\CutisResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateCutis extends CreateRecord
{
    protected static string $resource = CutisResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 'pending';
        return $data;
    }
}
