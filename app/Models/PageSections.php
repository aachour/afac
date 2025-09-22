<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSections extends Model
{
    //

    public function sections()
    {
        return $this->belongsTo(Sections::class, 'section_id', 'id');
    }

    public function collections()
    {
        return $this->belongsTo(Collections::class, 'collection_id', 'id');
    }
}
