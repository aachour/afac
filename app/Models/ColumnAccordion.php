<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColumnAccordion extends Model
{
    
    use SoftDeletes;

    protected $fillable = [
        'section_column_id',
        'title',
        'text',
        'list_order',
    ];

    public function column()
    {
        return $this->belongsTo(SectionColumns::class, 'section_column_id', 'id');
    }

}
