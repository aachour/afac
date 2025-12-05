<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collections extends Model
{

    use SoftDeletes;

    //
    protected $fillable = [
        'type_id',
        'calendar_view',
        'name',
        'name_arabic',
        'show_name',
        'description',
        'description_arabic',
        'show_description',
        'description_position',
        'view_all_title',
        'view_all_title_arabic',
        'view_all_link',
        'view_all_link_arabic',
        'show_view_all',
        'background_color_id',
        'with_border_bottom',
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
        'all_featured',
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
