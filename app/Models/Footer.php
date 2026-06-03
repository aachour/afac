<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Footer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'col1', 'col1_links', 'col1_arabic', 'col1_arabic_links',
        'col2', 'col2_links', 'col2_arabic', 'col2_arabic_links',
        'col3', 'col3_links', 'col3_arabic', 'col3_arabic_links',
    ];

    protected $casts = [
        'col1_links'         => 'array',
        'col1_arabic_links'  => 'array',
        'col2_links'         => 'array',
        'col2_arabic_links'  => 'array',
        'col3_links'         => 'array',
        'col3_arabic_links'  => 'array',
    ];
}
