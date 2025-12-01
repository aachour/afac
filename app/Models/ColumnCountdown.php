<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ColumnCountdown extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'section_column_id',
        'bg_color_id',
        'title',
        'title_arabic',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'button_value',
        'button_value_arabic',
        'button_shape_id',
        'button_hover_shape_id',
        'button_bg_color_id',
        'button_hover_bg_color_id',
        'button_link',
        'button_link_arabic',
        'list_order',
    ];

    public function column()
    {
        return $this->belongsTo(SectionColumns::class, 'section_column_id', 'id');
    }


}
