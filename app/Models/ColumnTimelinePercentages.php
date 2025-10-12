<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColumnTimelinePercentages extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'timeline_id',
        'title',
        'text',
        'shape',
        'percentage',
        'list_order',
    ];

    public function column()
    {
        return $this->belongsTo(SectionColumns::class, 'section_column_id', 'id');
    }

}
