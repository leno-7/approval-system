<?php
namespace App\Observers;

use App\Models\Contract;
use App\Models\PlanningGovernanceApproval;

class ContractObserver
{
    public function updated(Contract $contract)
    {
        if (
            $contract->approved_by_procurement_specialist &&
            $contract->approved_by_procurement_manager
        ) {
            $exists = PlanningGovernanceApproval::where('project_request_id', $contract->project_request_id)->exists();

            if (! $exists) {
                PlanningGovernanceApproval::create([
                    'project_request_id' => $contract->project_request_id,
                ]);
            }
        }
    }
}

