<?php

namespace App\Filament\Resources\Cutis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class CutisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail')
                    ->schema([
                        DatePicker::make('start_date')
                            ->required(),
                        DatePicker::make('end_date')
                            ->required(),
                        Textarea::make('reason')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected'
                            ])
                            ->required(),
                        Textarea::make('Note')
                            ->columnSpanFull(),
                    ]),
            ]);

        // if (Auth::user()->hasRole('super_admin')) {
        //     $schema->components([
        //         Section::make('Approval')
        //             ->schema([
        //                 Select::make('status')
        //                     ->options([
        //                         'pending' => 'Pending',
        //                         'approved' => 'Approved',
        //                         'rejected' => 'Rejected'
        //                     ])
        //                     ->required(),
        //                 Textarea::make('Note')
        //                     ->columnSpanFull(),
        //             ]),
        //     ]);
        // }
    }
}
