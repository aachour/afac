<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramYearJurors extends Model
{
    //

    use SoftDeletes;

    protected $guarded = [];

    public function jurorDetails()
    {
        return $this->belongsTo(Entries::class, 'juror_id', 'id');
    }

    public function programYear()
    {
        return $this->belongsTo(ProgramYears::class, 'program_year_id', 'id');
    }
    
}
