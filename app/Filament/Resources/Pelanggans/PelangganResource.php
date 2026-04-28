<?php

namespace App\Filament\Resources\Pelanggans;

use App\Filament\Resources\Pelanggans\Pages\ManagePelanggans;
use App\Models\Pelanggan;
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

class PelangganResource extends Resource
{
    protected static ?string $model = Pelanggan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Pelanggan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nmpelanggan')
                    ->required()
                    ->maxLength(55),
                TextInput::make('nohp')
                    ->label('Nomor Hp')
                    ->maxLength(12)
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Pelanggan')
            ->columns([
                TextColumn::make('nmpelanggan')
                    ->searchable(),
                TextColumn::make('nohp')
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
            'index' => ManagePelanggans::route('/'),
        ];
    }
}
