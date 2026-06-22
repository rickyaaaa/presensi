<?php

namespace App\Filament\Resources\ShiftModels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;

class ShiftModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                ->schema([
                    Section::make()
                    ->schema([
                        TextInput::make('name')->maxLength(50),
                        TimePicker::make('start_time')->required(),
                        TimePicker::make('end_time')->required(),
                    ]),
                ]),

                //
            ]);
    }
}
