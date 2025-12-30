<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = [
        'name',
        'description',
        'quota',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'quota' => 'integer',
    ];

    // RELATIONSHIPS

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    // HELPER METHODS

    /**
     * Get remaining quota
     */
    public function getRemainingQuota($batchId = null): int
    {
        $query = $this->registrations()
            ->whereIn('status', ['paid', 'exam_scheduled', 'interview_scheduled', 'finished', 'accepted']);

        if ($batchId) {
            $query->where('batch_id', $batchId);
        }

        $registered = $query->count();

        return max(0, $this->quota - $registered);
    }

    /**
     * Check if quota is full
     */
    public function isQuotaFull($batchId = null): bool
    {
        return $this->getRemainingQuota($batchId) <= 0;
    }

    /**
     * Get quota usage percentage
     */
    public function getQuotaPercentage($batchId = null): float
    {
        $registered = $this->registrations()
            ->whereIn('status', ['paid', 'exam_scheduled', 'interview_scheduled', 'finished', 'accepted']);

        if ($batchId) {
            $registered->where('batch_id', $batchId);
        }

        $count = $registered->count();

        return $this->quota > 0 ? round(($count / $this->quota) * 100, 2) : 0;
    }

    // SCOPES

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
}
