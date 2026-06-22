<?php

namespace App\Filament\Resources\JadwalModels;

use App\Filament\Resources\JadwalModels\Pages\CreateJadwalModel;
use App\Filament\Resources\JadwalModels\Pages\EditJadwalModel;
use App\Filament\Resources\JadwalModels\Pages\ListJadwalModels;
use App\Filament\Resources\JadwalModels\Schemas\JadwalModelForm;
use App\Filament\Resources\JadwalModels\Tables\JadwalModelsTable;
use App\Models\JadwalModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JadwalModelResource extends Resource
{
    protected static ?string $model = JadwalModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;
    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'Jadwal';
    protected static ?string $navigationLabel = 'Jadwal Pegawai';
    protected static ?string $breadcrumb = 'Jadwal Pegawai';

    public static function form(Schema $schema): Schema
    {
        return JadwalModelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JadwalModelsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJadwalModels::route('/'),
            'create' => CreateJadwalModel::route('/create'),
            'edit' => EditJadwalModel::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
