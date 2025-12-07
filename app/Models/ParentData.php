<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentData extends Model
{
    protected $table = 'parents';

    protected $fillable = [
        'registration_id',
        'father_name',
        'mother_name',
        'guardian_name',
        'contact',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}