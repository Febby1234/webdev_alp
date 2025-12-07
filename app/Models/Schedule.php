<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'batch_id',
        'date',
        'time',
        'location',
        'type',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
