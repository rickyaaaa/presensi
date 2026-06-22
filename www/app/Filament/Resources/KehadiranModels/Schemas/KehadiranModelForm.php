<?php

namespace App\Filament\Resources\KehadiranModels\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Date;

class KehadiranModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                ->schema([
                    Section::make()
                    ->schema([
                        DatePicker::make('created_at')
                            ->label('Tanggal Presensi')
                            ->displayFormat('Y-m-d H:i:s')
                            ->required(),
                        Select::make('user')
                            ->relationship('user', 'name')
                            ->disabled()
                            ->label('Pegawai')
                            //->searchable()
                            ->required(),
                        TextInput::make('jadwal_latitude')
                            ->label('Latitude Jadwal')
                            ->required(),
                        TextInput::make('jadwal_longitude')
                            ->label('Longitude Jadwal')
                            ->required(),
                        TextInput::make('jadwal_start_time')
                            ->label('Jadwal Mulai')
                            ->required(),
                        TextInput::make('jadwal_end_time')
                            ->label('Jadwal Selesai')
                            ->required(),
                        TextInput::make('start_time')
                            ->label('Waktu Masuk')
                            ->required(),
                        TextInput::make('end_time')
                            ->label('Waktu Keluar')
                            ->required(),
                        TextInput::make('start_latitude')
                            ->label('Latitude Masuk')
                            ->required(),
                        TextInput::make('start_longitude')
                            ->label('Longitude Masuk')
                            ->required(),
                        TextInput::make('end_latitude')
                            ->label('Latitude Keluar')
                            ->required(),
                        TextInput::make('end_longitude')
                            ->label('Longitude Keluar')
                            ->required(),

                    ]),
                ]),
            ]);
    }
}
