<?php

namespace App\Filament\Resources\JadwalModels\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Toggle;

class JadwalModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                ->schema([
                    Section::make()
                    ->schema([
                        Select::make('user_id')
                            ->label('Pegawai')
                            ->relationship('user', 'name')
                            //->searchable()
                            ->required(),
                        Select::make('shift_id')
                            ->label('Shift')
                            ->relationship('shift', 'name')
                            //->searchable()
                            ->required(),
                        Select::make('kantor_id')
                            ->label('Kantor')
                            ->relationship('kantor', 'name')
                            //->searchable()
                            ->required(),
                        Toggle::make('is_wfa')
                    ]),
                ]),

                //
            ]);
    }
}
