<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Events extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'title_arabic',
        'date',
        'start_time',
        'end_time',
        'image',
        'image_width',
        'background_color_id',
        'button_link',
        'button_link_arabic',
        'button_value',
        'button_value_arabic',
    ];

    public function category()
    {
        return $this->hasOne(EventCategories::class, 'id', 'category_id');
    }

}
