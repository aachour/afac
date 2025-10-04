<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectionColumns extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'section_id',
        'type_id',
        'alignment_id',
    ];

    public function gallery()
    {
        return $this->hasOne(Gallery::class, 'id', 'gallery_id');
    }

}
