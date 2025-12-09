<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColumnTimelinePercentages extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'timeline_id',
        'text',
        'text_arabic',
        'shape_id',
        'percentage',
        'percentage_color_id',
        'list_order',
    ];

    public function column()
    {
        return $this->belongsTo(SectionColumns::class, 'section_column_id', 'id');
    }

    public function color()
    {
        return $this->hasOne(Colors::class, 'id', 'percentage_color_id');
    }

}
