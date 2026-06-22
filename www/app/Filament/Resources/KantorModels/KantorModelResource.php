<?php

namespace App\Filament\Resources\KantorModels;

use App\Filament\Resources\KantorModels\Pages\CreateKantorModel;
use App\Filament\Resources\KantorModels\Pages\EditKantorModel;
use App\Filament\Resources\KantorModels\Pages\ListKantorModels;
use App\Filament\Resources\KantorModels\Schemas\KantorModelForm;
use App\Filament\Resources\KantorModels\Tables\KantorModelsTable;
use App\Models\KantorModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KantorModelResource extends Resource
{
    protected static ?string $model = KantorModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice2;
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'Kantor';
    protected static ?string $navigationLabel = 'Kantor';
    protected static ?string $breadcrumb = 'Kantor';

    public static function form(Schema $schema): Schema
    {
        return KantorModelForm::configure($schema);
    }
    // public static function form(Form $form): Form
    // {
    // //     return $form
    //     ->schema([
    //         Forms\Components\TextInput::make('name')
    //             ->required()
    //             ->maxLength(255),
    //     ]);
    // }


    public static function table(Table $table): Table
    {
        return KantorModelsTable::configure($table);
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
            'index' => ListKantorModels::route('/'),
            'create' => CreateKantorModel::route('/create'),
            'edit' => EditKantorModel::route('/{record}/edit'),
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
