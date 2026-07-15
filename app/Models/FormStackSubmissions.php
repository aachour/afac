<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormStackSubmissions extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'form_id',
        'submission_id',
        'email',
        'name',
        'admin_id',
        'admin_status',
        'admin_notes',
        'admin_internal_labels',
        'pm_internal_labels',
        'juror_internal_labels',
    ];

    protected $casts = [
        'admin_internal_labels' => 'array',
        'pm_internal_labels'    => 'array',
        'juror_internal_labels' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(FormStackForms::class, 'form_id', 'form_id');
    }

}
