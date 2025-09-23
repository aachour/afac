<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PageSections extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'page_id',
        'section_id',
        'collection_id',
        'list_order',
    ];

    public function page()
    {
        return $this->hasOne(Pages::class, 'id', 'page_id');
    }

    public function section()
    {
        return $this->hasOne(Sections::class, 'id', 'section_id');
    }

    public function collection()
    {
        return $this->hasOne(collections::class, 'id', 'collection_id');
    }

    public function sections()
    {
        return $this->belongsTo(Sections::class, 'section_id', 'id');
    }

    public function collections()
    {
        return $this->belongsTo(Collections::class, 'collection_id', 'id');
    }
}
