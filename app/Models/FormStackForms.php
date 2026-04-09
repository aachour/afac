<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormStackForms extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'form_id',
        'form_name',
        'form_lang',
        'form_submissions',
        'form_is_workflow_form',
        'form_is_workflow_published',
        'form_created_at',
        'form_updated_at',
    ];

    public function submissions()
    {
        return $this->hasMany(FormStackSubmissions::class, 'form_id', 'form_id');
    }

    public function groups()
    {
        return $this->hasMany(FormStackGroups::class, 'form_id', 'form_id');
    }

}
