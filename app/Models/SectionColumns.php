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
        'width',
    ];

    public function gallery()
    {
        return $this->hasOne(Gallery::class, 'id', 'gallery_id');
    }

    public function generalInputs(){
        return $this->hasMany(ColumnGeneral::class, 'section_column_id', 'id')->whereNull('deleted_at')->orderBy('list_order');
    }

    public function timelines(){
        return $this->hasMany(ColumnTimeline::class, 'section_column_id', 'id')->whereNull('deleted_at')->orderBy('list_order');
    }

    public function accordions(){
        return $this->hasMany(ColumnAccordion::class, 'section_column_id', 'id')->whereNull('deleted_at')->orderBy('list_order');
    }

    public function countdowns(){
        return $this->hasMany(ColumnCountdown::class, 'section_column_id', 'id')->whereNull('deleted_at')->orderBy('list_order');
    }

    public function expandingTexts(){
        return $this->hasMany(ColumnExpandTexts::class, 'section_column_id', 'id')->whereNull('deleted_at')->orderBy('list_order');
    }

    public function patterns(){
        return $this->hasMany(ColumnPattern::class, 'section_column_id', 'id')->whereNull('deleted_at')->orderBy('list_order');
    }

}
