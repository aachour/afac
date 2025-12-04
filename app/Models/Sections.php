<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sections extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'page_id',
        'name',
        'bg_color_id',
        'with_border_bottom',
    ];

    public function page()
    {
        return $this->belongsTo(Pages::class, 'page_id', 'id');
    }

    public function columns()
    {
        return $this->hasMany(SectionColumns::class, 'section_id', 'id');
    }

    
}
