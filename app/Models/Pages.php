<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    //
    protected $fillable = [
        'name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'header_color_id',
        'footer_color_id',
        'in_menu',
        'published',
    ];
}
