<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormStackAssigns extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'group_id',
        'form_id',
        'submission_id',
        'juror_id',
        'reader_id',
        'form_type',
        'form_status',
        'form_rate1',
        'form_rate2',
        'form_rate3',
        'form_rate4',
        'form_notes',
    ];

    public function group()
    {
        return $this->belongsTo(FormStackGroups::class, 'group_id', 'id');
    }

    public function form()
    {
        return $this->belongsTo(FormStackForms::class, 'form_id', 'id');
    }

    public function submission()
    {
        return $this->belongsTo(FormStackSubmissions::class, 'submission_id', 'submission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
