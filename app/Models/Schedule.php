<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'batch_id',
        'type',
        'date',
        'time',
        'location',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // RELATIONSHIPS

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    /**
     * Many-to-Many relationship dengan Registration
     */
    public function registrations()
    {
        return $this->belongsToMany(Registration::class, 'registration_schedule')
            ->withPivot('attendance')
            ->withTimestamps();
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    // HELPER METHODS

    /**
     * Get type label
     */
    public function getTypeLabel(): string
    {
        $labels = [
            'exam'            => 'Ujian',
            'interview'       => 'Wawancara'
        ];

        return $labels[$this->type] ?? $this->type;
    }

    /**
     * Get formatted date and time
     */
    public function getFormattedDateTime(): string
    {
        return $this->date->format('d F Y') . ' pukul ' . $this->time;
    }

    /**
     * Check if schedule is upcoming
     */
    public function isUpcoming(): bool
    {
        return $this->date->isFuture();
    }

    /**
     * Check if schedule is today
     */
    public function isToday(): bool
    {
        return $this->date->isToday();
    }

    /**
     * Check if schedule has passed
     */
    public function hasPassed(): bool
    {
        return $this->date->isPast();
    }

    /**
     * Get participant count
     */
    public function getParticipantCount(): int
    {
        return $this->registrations()->count();
    }

    // SCOPES

    public function scopeExam($query)
    {
        return $query->where('type', 'exam')
            ->orWhere('type', 'Ujian Tertulis');
    }

    public function scopeInterview($query)
    {
        return $query->where('type', 'interview')
            ->orWhere('type', 'Ujian Wawancara');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString());
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date', now()->toDateString());
    }

    public function scopePast($query)
    {
        return $query->where('date', '<', now()->toDateString());
    }

    public function scopeByBatch($query, $batchId)
    {
        return $query->where('batch_id', $batchId);
    }
}
