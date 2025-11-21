<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LibraryFiles extends Model
{
    //

    use SoftDeletes;
    
    protected $fillable = [
        'title',
        'title_arabic',
        'path',
    ];

}
