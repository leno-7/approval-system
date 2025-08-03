<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportServiceApproval extends Model
{
    protected $fillable = [
        'project_request_id',
        'approved_by_support_exec',
        'approved_by_support_exec_at',
        'support_exec_notes',
    ];

    public function projectRequest()
{
    return $this->belongsTo(ProjectRequest::class, 'project_request_id');
}

}

