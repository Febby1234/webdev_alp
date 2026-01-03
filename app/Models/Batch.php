<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'batch_name',   // SESUAI DB (bukan 'name')
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_active'  => 'boolean',
    ];

    // RELATIONSHIPS

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // ACCESSOR - Untuk kompatibilitas dengan view yang pakai $batch->name

    public function getNameAttribute(): ?string
    {
        return $this->batch_name;
    }

    // HELPER METHODS

    /**
     * Check if registration is open
     */
    public function isOpen(): bool
    {
        $now = now()->toDateString();
        return $this->is_active &&
               $now >= $this->start_date->toDateString() &&
               $now <= $this->end_date->toDateString();
    }

    /**
     * Check if registration has closed
     */
    public function isClosed(): bool
    {
        return !$this->is_active || now()->toDateString() > $this->end_date->toDateString();
    }

    /**
     * Check if registration hasn't started yet
     */
    public function isUpcoming(): bool
    {
        return $this->is_active && now()->toDateString() < $this->start_date->toDateString();
    }

    /**
     * Get days remaining until close
     */
    public function getDaysRemaining(): int
    {
        if ($this->isClosed()) {
            return 0;
        }

        return max(0, now()->startOfDay()->diffInDays($this->end_date, false));
    }

    /**
     * Get status label
     */
    public function getStatusLabel(): string
    {
        if ($this->isUpcoming()) {
            return 'Akan Dibuka';
        } elseif ($this->isOpen()) {
            return 'Dibuka';
        } else {
            return 'Ditutup';
        }
    }

    /**
     * Get formatted date range
     */
    public function getDateRange(): string
    {
        return $this->start_date->format('d M Y') . ' - ' . $this->end_date->format('d M Y');
    }

    // SCOPES

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOpen($query)
    {
        $now = now()->toDateString();
        return $query->where('is_active', true)
            ->whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now);
    }

    public function scopeClosed($query)
    {
        return $query->where('is_active', false)
            ->orWhereDate('end_date', '<', now()->toDateString());
    }
}
