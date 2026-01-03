<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentData extends Model
{
    protected $table = 'parents';

    protected $fillable = [
        'registration_id',
        'father_name',
        'father_job',
        'father_phone',
        'mother_name',
        'mother_job',
        'mother_phone',
    ];

    // RELATIONSHIPS

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    // HELPER METHODS

    /**
     * Get primary contact (father's phone)
     */
    public function getPrimaryContact(): ?string
    {
        return $this->father_phone;
    }

    /**
     * Check if has complete parent data
     */
    public function isComplete(): bool
    {
        return !empty($this->father_name) && !empty($this->mother_name);
    }
}
