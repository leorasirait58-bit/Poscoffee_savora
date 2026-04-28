<?php

namespace App\Filament\Resources\Menus;

use App\Filament\Resources\Menus\Pages\ManageMenus;
use App\Models\Menu;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Textarea;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Menu';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nmmenu')
                    ->label('Nama Menu') 
                    ->required()
                    ->maxLength(255),

                Select::make('jenis_id')
                    ->relationship('kategori', 'nmKategori')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('harga')
                    ->numeric()
                    ->required(),

                FileUpload::make('foto') 
                    ->label('Gambar Menu')
                    ->image()
                    ->disk('public')
                    ->directory('menu')
                    ->visibility('public')
                    ->imagePreviewHeight('80'),

                Textarea::make('deskripsi')
                    ->label('Deskripsi') 
                    ->rows(3),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Menu')
            ->columns([

                ImageColumn::make('foto')
                  ->getStateUsing(fn ($record) => asset('storage/' . $record->foto))
                    ->square('50')
                    ->disk('public')
                    ->circular(),

                TextColumn::make('nmmenu')
                    ->searchable(),

                TextColumn::make('kategori.nmKategori')
                    ->label('Jenis Kategori')
                    ->searchable(),

                TextColumn::make('harga')
                    ->money('IDR', true),

                TextColumn::make('deskripsi')
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
            'index' => ManageMenus::route('/'),
        ];
    }
}