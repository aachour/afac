<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    //
    protected $fillable = [
        'name',
        'name_arabic',
        'meta_title',
        'meta_title_arabic',
        'meta_description',
        'meta_description_arabic',
        'meta_keywords',
        'meta_keywords_arabic',
        'header_color_id',
        'footer_color_id',
        'in_menu',
        'published',
    ];
}
