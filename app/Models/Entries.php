<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entries extends Model
{
    //

    use SoftDeletes;

    protected $guarded = [];

    public function type()
    {
        return $this->hasOne(Types::class, 'id', 'type_id');
    }

    public function headerBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'header_color_id');
    }

    public function footerBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'footer_color_id');
    }

    public function ImageBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'background_color_id');
    }

    public function eventCategory()
    {
        return $this->hasOne(EventCategories::class, 'id', 'event_category_id');
    }

    public function projectCategory()
    {
        return $this->hasOne(ProjectCategories::class, 'id', 'project_category_id');
    }

    public function granteeCountry()
    {
        return $this->hasOne(Countries::class, 'id', 'grantee_country_id');
    }

    public function juryCountry()
    {
        return $this->hasOne(Countries::class, 'id', 'jury_country_id');
    }
    
    public function externalCategory()
    {
        return $this->hasOne(ExternalCategories::class, 'id', 'external_category_id');
    }

}
