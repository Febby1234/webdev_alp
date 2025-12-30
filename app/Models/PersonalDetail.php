<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalDetail extends Model
{
    protected $fillable = [
        'registration_id',
        'full_name',
        'gender',
        'birth_place',
        'birth_date',
        'address',
        'phone'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // RELATIONSHIPS

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    // HELPER METHODS

    /**
     * Get age from birth date
     */
    public function getAge(): int
    {
        return $this->birth_date->age;
    }

    /**
     * Get formatted birth info
     */
    public function getFormattedBirthInfo(): string
    {
        return $this->birth_place . ', ' . $this->birth_date->format('d F Y');
    }
}
