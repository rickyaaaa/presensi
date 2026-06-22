<?php

namespace App\Filament\Resources\ShiftModels;

use App\Filament\Resources\ShiftModels\Pages\CreateShiftModel;
use App\Filament\Resources\ShiftModels\Pages\EditShiftModel;
use App\Filament\Resources\ShiftModels\Pages\ListShiftModels;
use App\Filament\Resources\ShiftModels\Schemas\ShiftModelForm;
use App\Filament\Resources\ShiftModels\Tables\ShiftModelsTable;
use App\Models\ShiftModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShiftModelResource extends Resource
{
    protected static ?string $model = ShiftModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Clock;
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'Shift';

    protected static ?string $navigationLabel = 'Shift';

    protected static ?string $breadcrumb = 'Shift';

    public static function form(Schema $schema): Schema
    {
        return ShiftModelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShiftModelsTable::configure($table);
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
            'index' => ListShiftModels::route('/'),
            'create' => CreateShiftModel::route('/create'),
            'edit' => EditShiftModel::route('/{record}/edit'),
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
