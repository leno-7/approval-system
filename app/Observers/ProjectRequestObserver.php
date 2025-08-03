<?php

namespace App\Observers;

use App\Models\ProjectRequest;
use App\Models\ProjectRequestCompletion;

class ProjectRequestObserver
{
   /* public function created(ProjectRequest $projectRequest)
    {
        ProjectRequestCompletion::firstOrCreate([
            'project_request_id' => $projectRequest->id,
        ]);
    }
*/public function updated(ProjectRequest $project)
{
    if (
        $project->approved_by_owner_director &&
        $project->approved_by_second_owner &&
        $project->approved_by_first_owner
    ) {
        // إنشاء سجل إدارة المشاريع (إن لم يوجد)
        $project->completion()->firstOrCreate([]);
        
        
    }
}

        
        
    }





