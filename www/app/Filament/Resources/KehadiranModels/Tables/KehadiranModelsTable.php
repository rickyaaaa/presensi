<?php

namespace App\Filament\Resources\KehadiranModels\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class KehadiranModelsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function(Builder $query) {
                $is_super_admin = auth::user()->hasRole('super_admin');

                if (!$is_super_admin) {
                    $query->where('user_id', Auth::user()->id);
                }
            })
            ->columns([
                TextColumn::make('created_at')->label('Tanggal Presensi')->date()->sortable()->searchable(),
                TextColumn::make('user.name')->label('Pegawai')->searchable(),
                TextColumn::make('is Late')->label('Status')->getStateUsing(function($record) {
                    return $record->isTerlambat() ? 'Tepat Waktu' : 'Terlambat';
                })->badge()->color(function($state) {
                    return $state === 'Tepat Waktu' ? 'success' : 'danger';
                }),
                //TextColumn::make('jadwal_latitude')->label('Latitude Jadwal'),
                //TextColumn::make('jadwal_longitude')->label('Longitude Jadwal'),
                //TextColumn::make('jadwal_start_time')->label('Jadwal Mulai'),
                //TextColumn::make('jadwal_end_time')->label('Jadwal Selesai'),
                //TextColumn::make('start_latitude')->label('Latitude Masuk'),
                //TextColumn::make('start_longitude')->label('Longitude Masuk'),
                TextColumn::make('start_time')->label('Waktu Masuk'),
                TextColumn::make('end_time')->label('Waktu Keluar'),
                TextColumn::make('durasiKerja')->label('Durasi Kerja') ->getStateUsing(function($record) {
                    return $record->durasiKerja();
                }),
                //TextColumn::make('end_latitude')->label('Latitude Keluar'),
                //TextColumn::make('end_longitude')->label('Longitude Keluar'),
                //
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
