<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramYears extends Model
{
    //

    use SoftDeletes;

    protected $guarded = [];


    public function program()
    {
        return $this->belongsTo(Entries::class, 'program_id', 'id');
    }

    public function projects()
    {
        return $this->hasMany(ProgramYearProjects::class, 'program_year_id', 'id')->orderBy('list_order', 'ASC');
    }

    public function jurors()
    {
        return $this->hasMany(ProgramYearJurors::class, 'program_year_id', 'id')->orderBy('list_order', 'ASC');
    }

}
