<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collections extends Model
{

    use SoftDeletes;

    //
    protected $fillable = [
        'types',
        'colors',
        'editing = false',
        'collection',
        'id',
        'type_id',
        'name',
        'name_arabic',
        'description',
        'description_arabic',
        'description_position',
        'background_color_id',
        'with_filters',
        'filter_fields',
        'entries_selection',
        'entries_number',
        'entries_with_expired',
        'entries_order',
        'title_position',
        'with_label',
        'entries_layout',
        'entries_per_row',
        'with_featured_image',
        'featured_image_width',
        'featured_image_background_color_id',	
        'featured_image_description',
        'featured_image_description_arabic',
        'featured_image_description_position',
        
    ];

    public function type()
    {
        return $this->hasOne(Types::class, 'id', 'type_id');
    }

    public function bgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'background_color_id');
    }

    public function featuredImageBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'featured_image_background_color_id');
    }

}
