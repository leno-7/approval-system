<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRequest extends Model
{
    protected $fillable = [
        'request_date',
        'owner_department',
        'project_name',
        'estimated_value',
        'estimated_value_text',
        'specifications_attachment',
        'project_type',
        'duration_day',
        'duration_month',
        'duration_year',
        'project_description',
        'project_scope',
        'project_objectives',
        'suggested_vendors',
        'notes',
        'approved_by_owner_director',
        'approved_by_owner_director_at',
        'owner_director_notes',
        'approved_by_second_owner',
        'approved_by_second_owner_at',
        'second_owner_notes',
        'approved_by_first_owner',
        'approved_by_first_owner_at',
        'first_owner_notes',
    ];

    protected $casts = [
        'request_date' => 'date',
        'specifications_attachment' => 'array',
        'project_objectives' => 'array',
        'suggested_vendors' => 'array',
    ];

    protected static function booted(): void
    {

        static::creating(function ($model) {
            // توليد رقم المشروع تلقائيًا عند الإنشاء
            $latestNumber = static::max('project_number');
            $model->project_number = $latestNumber ? $latestNumber + 1 : 1;

            // توليد القيمة التقديرية كتابةً إذا لم تكن موجودة
            if (! $model->estimated_value_text && $model->estimated_value) {
             $model->estimated_value_text = self::numberToWords($model->estimated_value);
            }
            
        });


       /* static::saving(function ($model) {
            if ($model->isDirty('approved_by_owner_director') && $model->approved_by_owner_director && !$model->approved_by_owner_director_at) {
                $model->approved_by_owner_director_at = now();
            }
    
            if ($model->isDirty('approved_by_second_owner') && $model->approved_by_second_owner && !$model->approved_by_second_owner_at) {
                $model->approved_by_second_owner_at = now();
            }
    
            if ($model->isDirty('approved_by_first_owner') && $model->approved_by_first_owner && !$model->approved_by_first_owner_at) {
                $model->approved_by_first_owner_at = now();
            }
        }); */

    }


     public static function numberToWords($number): string
    {
        $formatter = new \NumberFormatter('ar', \NumberFormatter::SPELLOUT);
        return $formatter->format($number);
    }

    public function completion()
    {
        return $this->hasOne(ProjectRequestCompletion::class);
    }


    public function financialAffair()
{
    return $this->hasOne(\App\Models\FinancialAffair::class);
}
// app/Models/ProjectRequest.php

public function contract()
{
    return $this->hasOne(\App\Models\Contract::class);
}

public function planningGovernanceApproval()
{
    return $this->hasOne(\App\Models\PlanningGovernanceApproval::class);
}


public function supportServiceApproval()
{
    return $this->hasOne(\App\Models\SupportServiceApproval::class);
}
}
