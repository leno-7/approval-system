<?php

namespace App\Filament\Resources\FinancialAffairResource\Pages;

use App\Filament\Resources\FinancialAffairResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinancialAffairs extends ListRecords
{
    protected static string $resource = FinancialAffairResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
