<?php

namespace App\Filament\Resources\KantorModels\Schemas;
// namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Humaidem\FilamentMapPicker\Fields\OSMMap;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Filament\Forms\Components\Field;

use Filament\Resources\Resource;
use Filament\Resources\Forms\Form;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;

class KantorModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                ->schema([
                    Section::make()
                    ->schema([
                    TextInput::make('name')
                        ->required(),
                    OSMMap::make('location')
                        ->afterStateUpdated(function ($state, callable $set) {
                            if (is_array($state) && isset($state['lat'], $state['lng'])) {
                                $set('latitude', $state['lat']);
                                $set('longitude', $state['lng']);
                            }
                        })
                        // ->afterStateHydrated(function ($state, $set) {
                        //     if (is_array($state) && isset($state['lat'], $state['lng'])) {
                        //         $set('location', [
                        //             'lat' => $state['lat'],
                        //             'lng' => $state['lng'],
                        //         ]);
                        //     }
                        // })
                        // ->mutateDehydratedStateUsing(function ($state) {
                        //     if (is_array($state) && isset($state['lat'], $state['lng'])) {
                        //         return [
                        //             'lat' => $state['lat'],
                        //             'lng' => $state['lng'],
                        //         ];
                        //     }

                        //     return $state;
                        // })
                        // ->afterStateUpdated(function ($state, $set) {
                        //     if (is_array($state) && isset($state['lat']) && isset($state['lng'])) {
                        //         $set('location', [
                        //             'lat' => $state['lat'],
                        //             'lng' => $state['lng'],
                        //         ]);
                        //     }
                        // })
                        ->label('Location')
                        ->showMarker()
                        ->draggable()
                        ->extraControl([
                            'zoomDelta'           => 1,
                            'zoomSnap'            => 0.25,
                            'wheelPxPerZoomLevel' => 60,
                        ])
                        ->default(function ($record) {
                            if ($record && $record->latitude && $record->longitude) {
                                return [
                                    'lat' => $record->latitude,
                                    'lng' => $record->longitude,
                                ];
                            }
                            return null;
                        })
                        ->dehydrated(false)
                        // ->afterStateHydrated(function ($state, callable $set) {
                        //     if ($state instanceof Point) {
                        //         $set('location', [
                        //             'lat' => $state->getLat(),
                        //             'lng' => $state->getLng(),
                        //         ]);
                        //     }
                        // })
                        // ->afterStateUpdated(function ($state, callable $set) {
                        //     if ($state instanceof Point) {
                        //         $set('location', [
                        //             'lat' => $state->getLat(),
                        //             'lng' => $state->getLng(),
                        //         ]);
                        //     }
                        // })
                        ->tilesUrl('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'),
                    TextInput::make('latitude')
                        ->required()
                        ->numeric(),
                    TextInput::make('longitude')
                        ->required()
                        ->numeric(),
                    TextInput::make('radius')
                        ->required()
                        ->numeric(),
                    //
                ])
                ])
            ]);
    }
}
