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
        'text',
        'gallery',
        'video',
        'percentage',
        'button_value',
        'button_shape',
        'button_link',
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

}
