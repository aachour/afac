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
        'admin_status',
        'admin_notes',
        
    ];

}
