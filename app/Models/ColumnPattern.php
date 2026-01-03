<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColumnPattern extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'section_column_id',
        'button_text',
        'button_text_arabic',
        'button_shape_id',
        'button_hover_shape_id',
        'button_color_id',
        'button_hover_color_id',
        'button_bg_color_id',
        'button_hover_bg_color_id',
        'button_link',
        'button_link_arabic',
        'list_order',
    ];

    public function shape()
    {
        return $this->hasOne(Shapes::class, 'id', 'button_shape_id');
    }

    public function shapeHover()
    {
        return $this->hasOne(Shapes::class, 'id', 'button_hover_shape_id');
    }

    public function buttonBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'button_bg_color_id');
    }

    public function buttonhoverBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'button_hover_bg_color_id');
    }
}
