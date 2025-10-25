<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectGrantees extends Model
{
    //

    use SoftDeletes;

    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Entries::class, 'project_id', 'id');
    }

    public function grantee()
    {
        return $this->belongsTo(Entries::class, 'grantee_id', 'id');
    }
}
