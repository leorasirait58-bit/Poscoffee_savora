<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageOrders extends ManageRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {

        $total = 0;

        foreach ($data['details'] ?? [] as $item) {
            $harga = (int )($item['harga'] ?? 0);
            $jumlah = (int) $item['jumlah'] ?? 0;

            $total += $harga * $jumlah;
        }
        $data['total_harga'] = $total;

        return $data;
    }),
        ];
    }
     
    protected function afterCreate(): void
    {
        $record = $this->getRecord();
        $record->load('details');

        $total = 0;

        foreach ($record->details as $item) {
            $subtotal = (int)$item->harga * (int)$item->jumlah;

            //update subtotal kalau kosong
            $item->update([
                'subtotal'=>$subtotal
            ]);
            $total += $subtotal;
        }
        $record->update([
            'total_harga' => $total
        ]);
    }
}
