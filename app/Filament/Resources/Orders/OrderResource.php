<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\ManageOrders;
use App\Models\Order;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Actions\Action;

class OrderResource extends Resource
{
    
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Order';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
                DatePicker::make('tgl_order')
                    ->required(),
                Select::make('karyawan_id')
                    ->relationship('karyawan','nmkaryawan')
                    ->required(),
                Select::make('pelanggan_id')
                    ->relationship('pelanggan','nmpelanggan')
                    ->required(),
                Select::make('meja_id')
                    ->relationship('meja','nomor')
                    ->required(),
                Select::make('status')
                    ->options([
                        'pending'=>'Pending',
                        'proses'=>'Proses',
                        'selesai'=>'Selesai'
                    ])
                    ->default('pending')
                    ->required(),
                

            //Repeater (orderDetail)   
                Repeater::make('details')
                ->relationship()
                ->schema([
                    Select::make('menu_id')
                        ->relationship('menu','nmmenu')
                        ->reactive()
                        ->preload()
                        ->afterStateUpdated(function ($state, Set $set) {
                            $menu = \App\Models\Menu::find($state);
                            if ($menu ) {
                                $set('harga',$menu->harga);
                            }
                        })
                        ->required(),
                    TextInput::make('harga')
                        ->numeric()
                        ->readOnly()
                        ->dehydrated()
                        ->default(0),
                    TextInput::make('jumlah')
                        ->numeric()
                        ->reactive()
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            $set('subtotal', $get('harga') * $get ('jumlah'));
                        })
                        ->dehydrated(true)
                        ->required(),
                    TextInput::make('subtotal')
                        ->numeric()
                        ->disabled()
                        ->dehydrated(),
                        ])
                        ->columns(1)
                        ->defaultItems(1)
                        ->reactive()
                        ->afterStateUpdated(function (Get $get, Set $set) {
                        $details = $get('details') ?? [];
                        $total = collect($details)->sum(function ($item) {
                        $harga = (int) ($item['harga'] ?? 0);
                        $jumlah   = (int) ($item['jumlah'] ?? 0);

                            return $harga * $jumlah;
                        });

                        $set('total_harga', $total);
                    }),
                    TextInput::make('total_harga')
                        ->numeric()
                        ->disabled()
                        ->dehydrated(),
                      
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Order')
            ->columns([
                TextColumn::make('tgl_order')
                    ->date()
                    ->label('Tanggal Order')
                    ->sortable(),
                TextColumn::make('karyawan.nmkaryawan')
                    ->label('Kasir'),
                TextColumn::make('pelanggan.nmpelanggan')
                    ->label('Pelanggan'),
                TextColumn::make('meja.nomor')
                    ->label('No.meja'),
                TextColumn::make('total_harga')
                    ->money('IDR', true)
                    ->label('Total'),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'pending'=>'warning',
                        'proses'=>'primary',
                        'selesai'=>'success',
                    ])
                    ->label('Status'),
                TextColumn::make('details.menu.nmmenu')
                    ->label('Menu')
                    ->listWithLineBreaks()
                    ->bulleted(),
                    
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->filters([
                //
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
            'index' => ManageOrders::route('/'),
        ];
    }
    
}
