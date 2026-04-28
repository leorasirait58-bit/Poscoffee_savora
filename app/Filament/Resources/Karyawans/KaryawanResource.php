<?php

namespace App\Filament\Resources\Karyawans;

use App\Filament\Resources\Karyawans\Pages\ManageKaryawans;
use App\Models\Karyawan;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\FileUpload;

class KaryawanResource extends Resource
{
    protected static ?string $model = Karyawan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Karyawan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nmkaryawan')
                    ->label('Nama Karyawan')
                    ->required()
                    ->maxLength(55)
                    ->placeholder('Masukkan Nama Karyawan'),
                Textarea::make('alamat')
                    ->rows(3)
                    ->autosize()
                    ->placeholder('Maukkan Alamat'),
                TextInput::make('nohp')
                    ->label('Nomor Hp')
                    ->maxLength(12)
                    ->required(),
                Radio::make('status')
                    ->label('Status Karyawan')
                    ->options([
                      'active' => 'Active',
                      'inactive' => 'Inactive'])
                    ->default('active')
                     ->inline(),
                FileUpload::make('foto')
                    ->label('Foto Karyawan')
                    ->image()
                    ->disk('public')
                    ->directory('foto_karyawan')
                    ->visibility('public')
                    ->imagePreviewHeight('80')
                    ->loadingIndicatorPosition('left'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Karyawan')
            ->columns([
                ImageColumn::make('foto')
                    ->imageHeight(50)
                    ->disk('public')
                    ->circular(),
                TextColumn::make('nmkaryawan')
                    ->searchable(),
                TextColumn::make('alamat')
                    ->searchable(),
                TextColumn::make('nohp')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'secondary',
                    })
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
            'index' => ManageKaryawans::route('/'),
        ];
    }
}
