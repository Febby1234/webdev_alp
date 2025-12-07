<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = [
        'name',
        'description',
        'quota',
        'is_active'
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}