<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColumnExpandTexts extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'section_column_id',
        'text',
        'text_arabic',
        'visible',
        'list_order',
    ];

    public function column()
    {
        return $this->belongsTo(SectionColumns::class, 'section_column_id', 'id');
    }

}
