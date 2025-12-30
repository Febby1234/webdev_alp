<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = [
        'registration_id',
        'schedule_id',
        'interviewer_id',
        'score',
        'notes',
        'status',
    ];

    protected $casts = [
        'score' => 'integer',
    ];

    // RELATIONSHIPS

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function interviewer()
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    // HELPER METHODS

    /**
     * Check if passed
     */
    public function isPassed(): bool
    {
        return $this->status === 'pass';
    }

    /**
     * Check if failed
     */
    public function isFailed(): bool
    {
        return $this->status === 'fail';
    }

    /**
     * Get status label with color
     */
    public function getStatusBadge(): array
    {
        $badges = [
            'pending' => ['label' => 'Menunggu', 'color' => 'warning'],
            'pass' => ['label' => 'Lulus', 'color' => 'success'],
            'fail' => ['label' => 'Tidak Lulus', 'color' => 'danger'],
        ];

        return $badges[$this->status] ?? ['label' => 'Unknown', 'color' => 'secondary'];
    }

    /**
     * Get grade category based on score
     */
    public function getGrade(): string
    {
        if ($this->score >= 90) {
            return 'A';
        } elseif ($this->score >= 80) {
            return 'B';
        } elseif ($this->score >= 70) {
            return 'C';
        } elseif ($this->score >= 60) {
            return 'D';
        } else {
            return 'E';
        }
    }

    // SCOPES

    public function scopePassed($query)
    {
        return $query->where('status', 'pass');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'fail');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByInterviewer($query, $interviewerId)
    {
        return $query->where('interviewer_id', $interviewerId);
    }
}
