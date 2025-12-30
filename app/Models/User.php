<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Fields that can be mass assigned.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // student | admin | interviewer
    ];

    /**
     * Fields hidden from JSON output.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Field casting rules.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // RELATIONSHIPS

    /**
     * A user (student) may have many registrations.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Admin verifying payments.
     */
    public function verifiedPayments()
    {
        return $this->hasMany(Payment::class, 'verified_by');
    }

    /**
     * Interviewer giving exam scores.
     */
    public function examResults()
    {
        return $this->hasMany(ExamResult::class, 'interviewer_id');
    }

    /**
     * Announcements created by user.
     */
    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    // HELPER METHODS

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is interviewer
     */
    public function isInterviewer(): bool
    {
        return $this->role === 'interviewer';
    }

    /**
     * Check if user is student
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }
}
