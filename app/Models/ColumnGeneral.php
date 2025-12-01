<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ColumnGeneral extends Model
{
    
    use SoftDeletes;

    protected $fillable = [
        'section_column_id',
        'input_type_id',
        'bg_color_id',
        'title',
        'title_arabic',
        'text',
        'text_arabic',
        'gallery_id',
        'video',
        'percentage',
        'button_bg_image',
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

    public function bgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'bg_color_id');
    }

    public function inputType()
    {
        return $this->hasOne(InputTypes::class, 'id', 'input_type_id');
    }

    public function gallery()
    {
        return $this->hasOne(Gallery::class, 'id', 'gallery_id');
    }

    public function shape()
    {
        return $this->hasOne(Shapes::class, 'id', 'button_shape_id');
    }

    public function shapeHover()
    {
        return $this->hasOne(Shapes::class, 'id', 'button_hover_shape_id');
    }

    public function btnBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'button_bg_color_id');
    }

    public function btnHoverBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'button_hover_bg_color_id');
    }

}
