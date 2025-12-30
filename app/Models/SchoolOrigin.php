<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolOrigin extends Model
{
    protected $fillable = [
        'registration_id',
        'school_origin_name',
        'graduation_year',
        'average_grade',
    ];

    protected $casts = [
        'average_grade' => 'float',
    ];

    // RELATIONSHIPS

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    // HELPER METHODS

    /**
     * Get grade category
     */
    public function getGradeCategory(): string
    {
        if (!$this->average_grade) {
            return 'N/A';
        }

        if ($this->average_grade >= 90) {
            return 'Sangat Baik';
        } elseif ($this->average_grade >= 80) {
            return 'Baik';
        } elseif ($this->average_grade >= 70) {
            return 'Cukup';
        } else {
            return 'Kurang';
        }
    }

    /**
     * Check if recently graduated (within 2 years)
     */
    public function isRecentGraduate(): bool
    {
        $currentYear = now()->year;
        return ($currentYear - $this->graduation_year) <= 2;
    }
}
