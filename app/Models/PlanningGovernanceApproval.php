<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanningGovernanceApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_request_id',

        'approved_by_planning_director',
        'approved_by_planning_director_at',
        'planning_director_notes',

        'approved_by_ceo_assistant',
        'approved_by_ceo_assistant_at',
        'ceo_assistant_notes',
    ];

    /**
     * العلاقة مع المشروع الرئيسي
     */

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

    public function projectRequest()
    {
        return $this->belongsTo(ProjectRequest::class);
    }
}
