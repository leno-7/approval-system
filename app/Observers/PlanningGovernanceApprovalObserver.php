<?php
namespace App\Observers;

use App\Models\PlanningGovernanceApproval;
use App\Models\SupportServiceApproval;

class PlanningGovernanceApprovalObserver
{
    public function updated(PlanningGovernanceApproval $approval): void
    {
        // إذا تم الاعتماد من الطرفين ولم يكن هناك سجل في الخدمات المساندة
        if (
            $approval->approved_by_planning_director &&
            $approval->approved_by_ceo_assistant &&
            !$approval->projectRequest->supportServiceApproval
        ) {
            SupportServiceApproval::create([
                'project_request_id' => $approval->project_request_id,
            ]);
        }
    }
    protected static function booted(): void
{
    static::saving(function ($model) {
        if (
            $model->isDirty('approved_by_planning_director') &&
            $model->approved_by_planning_director &&
            !$model->approved_by_planning_director_at
        ) {
            $model->approved_by_planning_director_at = now();
        }

        if (
            $model->isDirty('approved_by_ceo_assistant') &&
            $model->approved_by_ceo_assistant &&
            !$model->approved_by_ceo_assistant_at
        ) {
            $model->approved_by_ceo_assistant_at = now();
        }
    });
}

}
