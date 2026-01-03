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
        return $this->birth_date ? $this->birth_date->age : 0;
    }

    /**
     * Get formatted birth info
     */
    public function getFormattedBirthInfo(): string
    {
        if (!$this->birth_date) {
            return $this->birth_place ?? '-';
        }
        return $this->birth_place . ', ' . $this->birth_date->format('d F Y');
    }

    /**
     * Get gender label
     */
    public function getGenderLabel(): string
    {
        return $this->gender === 'Laki-laki' ? 'Laki-laki' : 'Perempuan';
    }
}
