<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ExternalCategories extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'name',
        'name_arabic',
    ];
}
