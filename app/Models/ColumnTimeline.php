<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColumnTimeline extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'section_column_id',
        'date',
        'title',
        'text',
        'percentage',
        'list_order',
    ];

    public function column()
    {
        return $this->belongsTo(SectionColumns::class, 'section_column_id', 'id');
    }
}
