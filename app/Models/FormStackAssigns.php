<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormStackAssigns extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'form_id',
        'submission_id',
        'user_id',
        'grade',
        'notes',
    ];

}
