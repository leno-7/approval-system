<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRequestCompletion extends Model
{
    protected $fillable = [
        'project_request_id',
        'project_scope',
        'project_objectives',
        'project_status',
        'request_type',
        'related_projects',
        'suggested_vendors',
        'pmo_notes',
        'approved_by_pmo',
        'approval_date',
        'approved_by_pmo_at', // ✅
        'pmo_director_notes',
        'approved_by_specialist', // ✅
        'approved_by_specialist_at', // ✅
        'specialist_notes', // ✅
    ];

    protected $casts = [
        'project_objectives' => 'array',
        'suggested_vendors' => 'array',
        'approved_by_pmo' => 'boolean',
        'approval_date' => 'date',
    ];



    public function projectRequest()
    {
        return $this->belongsTo(ProjectRequest::class);
    }

  /*  protected static function booted(): void
{
    static::saving(function ($model) {
        if ($model->isDirty('approved_by_specialist') && $model->approved_by_specialist && !$model->approved_by_specialist_at) {
            $model->approved_by_specialist_at = now();
        }

        if ($model->isDirty('approved_by_pmo') && $model->approved_by_pmo && !$model->approved_by_pmo_at) {
            $model->approved_by_pmo_at = now();
        }

        // تاريخ الموافقة العام (لو موجود الحقل)
        if (! $model->approval_date) {
            $model->approval_date = now();
        }
    });
}*/


}
