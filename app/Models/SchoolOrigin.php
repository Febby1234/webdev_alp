<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolOrigin extends Model
{
    protected $fillable = [
        'registration_id',
        'school_name',
        'graduation_year',
        'average_score',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}