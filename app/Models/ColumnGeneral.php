<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ColumnGeneral extends Model
{
    
    use SoftDeletes;

    protected $fillable = [
        'section_column_id',
        'title',
        'text',
        'list_order',
    ];

    public function column()
    {
        return $this->belongsTo(SectionColumns::class, 'section_column_id', 'id');
    }

    public function bgColor()
    {
        return $this->hasOne(Colors::class, 'bg_color_id ', 'id');
    }

    public function inputType()
    {
        return $this->hasOne(inputTypes::class, 'input_type_id', 'id');
    }
    
}
