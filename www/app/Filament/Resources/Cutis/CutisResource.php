<?php

namespace App\Filament\Resources\Cutis;

use App\Filament\Resources\Cutis\Pages\CreateCutis;
use App\Filament\Resources\Cutis\Pages\EditCutis;
use App\Filament\Resources\Cutis\Pages\ListCutis;
use App\Filament\Resources\Cutis\Schemas\CutisForm;
use App\Filament\Resources\Cutis\Tables\CutisTable;
use App\Models\Cutis;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CutisResource extends Resource
{
    protected static ?string $model = Cutis::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Cuti';

    public static function form(Schema $schema): Schema
    {
        return CutisForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CutisTable::configure($table);
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
            'index' => ListCutis::route('/'),
            'create' => CreateCutis::route('/create'),
            'edit' => EditCutis::route('/{record}/edit'),
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
