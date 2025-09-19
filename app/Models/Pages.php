<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pages extends Model
{
    //

    use SoftDeletes;
    
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

    public function headerBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'header_color_id');
    }

    public function footerBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'footer_color_id');
    }

}
