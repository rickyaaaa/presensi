<?php

namespace App\Filament\Resources\KehadiranModels;

use App\Filament\Resources\KehadiranModels\Pages\CreateKehadiranModel;
use App\Filament\Resources\KehadiranModels\Pages\EditKehadiranModel;
use App\Filament\Resources\KehadiranModels\Pages\ListKehadiranModels;
use App\Filament\Resources\KehadiranModels\Schemas\KehadiranModelForm;
use App\Filament\Resources\KehadiranModels\Tables\KehadiranModelsTable;
use App\Models\KehadiranModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KehadiranModelResource extends Resource
{
    protected static ?string $model = KehadiranModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'kehadiran_model';

    public static function form(Schema $schema): Schema
    {
        return KehadiranModelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KehadiranModelsTable::configure($table);
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
            'index' => ListKehadiranModels::route('/'),
            'create' => CreateKehadiranModel::route('/create'),
            'edit' => EditKehadiranModel::route('/{record}/edit'),
        ];
    }
}
