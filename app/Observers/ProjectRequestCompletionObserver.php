<?php

namespace App\Observers;

use App\Models\ProjectRequestCompletion;

class ProjectRequestCompletionObserver
{
    public function updated(ProjectRequestCompletion $completion)
    {
        if (
            $completion->approved_by_specialist &&
            $completion->approved_by_pmo
        ) {
            $project = $completion->projectRequest;

            if ($project && !$project->financialAffair) {
                $project->financialAffair()->create([
                    'has_financial_approval' => 'لا',
                    'item_name' => '—',
                    'item_number' => '—',
                    'attachment_number' => '—',
                    'attachment_amount' => 0,
                    'attachment_date' => now(),
                ]);
            }
        }
    }
}
