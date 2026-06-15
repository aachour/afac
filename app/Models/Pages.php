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
        'show_name',
        'meta_title',
        'meta_title_arabic',
        'meta_description',
        'meta_description_arabic',
        'meta_keywords',
        'meta_keywords_arabic',
        'header_color_id',
        'footer_color_id',
        'in_menu',
        'menu_color_id',
        'published',
        'list_order',
    ];

    public function headerBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'header_color_id');
    }

    public function footerBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'footer_color_id');
    }

    public function menuBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'menu_color_id');
    }

    public function sections()
    {
        return $this->hasMany(Sections::class, 'page_id', 'id');
    }



}
