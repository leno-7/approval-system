<?php

namespace App\Filament\Resources\PlanningGovernanceApprovalResource\Pages;

use App\Filament\Resources\PlanningGovernanceApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlanningGovernanceApprovals extends ListRecords
{
    protected static string $resource = PlanningGovernanceApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
