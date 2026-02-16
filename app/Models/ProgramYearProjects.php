<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramYearProjects extends Model
{
    //
    use SoftDeletes;

    protected $guarded = [];



    public function programYear()
    {
        return $this->belongsTo(ProgramYears::class, 'program_year_id', 'id');
    }
    

    public function projectDetails()
    {
        return $this->belongsTo(Entries::class, 'project_id', 'id');
    }

}
