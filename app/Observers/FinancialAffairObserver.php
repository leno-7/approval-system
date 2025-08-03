<?php

namespace App\Observers;

use App\Models\FinancialAffair;

class FinancialAffairObserver
{
    public function updated(FinancialAffair $financialAffair)
    {
        if (
            $financialAffair->approved_by_specialist &&
            $financialAffair->approved_by_finance_director
        ) {
            $project = $financialAffair->projectRequest;

            if ($project && !$project->contract) {
                $project->contract()->create();
            }
        }
    }
}
