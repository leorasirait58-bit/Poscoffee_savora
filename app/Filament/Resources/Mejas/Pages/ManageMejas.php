<?php

namespace App\Filament\Resources\Mejas\Pages;

use App\Filament\Resources\Mejas\MejaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMejas extends ManageRecords
{
    protected static string $resource = MejaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
