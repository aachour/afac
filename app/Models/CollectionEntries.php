<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollectionEntries extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'collection_id',
        'entry_id',
        'list_order',
    ];

    public function collection()
    {
        return $this->belongsTo(Collections::class, 'collection_id', 'id');
    }

    public function entry()
    {
        return $this->belongsTo(entries::class, 'entry_id', 'id');
    }

}
