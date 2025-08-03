<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialAffair extends Model
{
    use HasFactory;

    protected $fillable = [
    'project_request_id',
    'has_financial_approval',
    'item_name',
    'item_number',
    'attachment_date',
    'attachment_number',
    'attachment_amount',
    'approved_by_specialist',
    'approved_by_specialist_at',
    'specialist_notes',
    'approved_by_finance_director',
    'approved_by_finance_director_at',
    'finance_director_notes',

    ];


    public function projectRequest()
    {
        return $this->belongsTo(ProjectRequest::class);
    }

   /* protected static function booted(): void
{
    static::saving(function ($model) {
        if ($model->isDirty('approved_by_specialist') && $model->approved_by_specialist && !$model->approved_by_specialist_at) {
            $model->approved_by_specialist_at = now();
        }

        if ($model->isDirty('approved_by_finance_director') && $model->approved_by_finance_director && !$model->approved_by_finance_director_at) {
            $model->approved_by_finance_director_at = now();
        }

        if (! $model->attachment_date) {
            $model->attachment_date = now();
        }
    });
}*/

}
