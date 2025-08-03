<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_request_id',
        'offering_duration',
        'offering_method',
        'is_preplanned',
        'submission_attachments',
        'approved_by_procurement_specialist',
        'approved_by_procurement_specialist_at',
        'procurement_specialist_notes',
        'approved_by_procurement_manager',
        'approved_by_procurement_manager_at',
        'procurement_manager_notes',
    ];

    protected $casts = [
        'is_preplanned' => 'boolean',
        'approved_by_procurement_specialist' => 'boolean',
        'approved_by_procurement_manager' => 'boolean',
        'approved_by_procurement_specialist_at' => 'date',
        'approved_by_procurement_manager_at' => 'date',
        'submission_attachments' => 'array',
    ];

    public function projectRequest()
    {
        return $this->belongsTo(ProjectRequest::class);
    }

  /*  protected static function booted(): void
{
    static::saving(function ($model) {
        if ($model->isDirty('approved_by_procurement_specialist') && $model->approved_by_procurement_specialist && !$model->approved_by_procurement_specialist_at) {
            $model->approved_by_procurement_specialist_at = now();
        }

        if ($model->isDirty('approved_by_procurement_manager') && $model->approved_by_procurement_manager && !$model->approved_by_procurement_manager_at) {
            $model->approved_by_procurement_manager_at = now();
        }
    });
}*/

}
