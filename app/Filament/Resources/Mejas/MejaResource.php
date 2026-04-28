<?php

namespace App\Filament\Resources\Mejas;

use App\Filament\Resources\Mejas\Pages\ManageMejas;
use App\Models\Meja;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MejaResource extends Resource
{
    protected static ?string $model = Meja::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Meja';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nomor')->numeric()
                    ->required()
                    ->maxLength(255),
                TextInput::make('jumlah_kursi')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Meja')
            ->columns([
                TextColumn::make('nomor')
                    ->searchable(),
                TextColumn::make('jumlah_kursi')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMejas::route('/'),
        ];
    }
}
