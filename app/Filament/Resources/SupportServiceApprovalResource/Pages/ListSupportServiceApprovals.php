<?php

namespace App\Filament\Resources\SupportServiceApprovalResource\Pages;

use App\Filament\Resources\SupportServiceApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupportServiceApprovals extends ListRecords
{
    protected static string $resource = SupportServiceApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
