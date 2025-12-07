<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalDetail extends Model
{
    protected $fillable = [
        'registration_id',
        'nik',
        'full_name',
        'birth_place',
        'birth_date',
        'gender',
        'address',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}