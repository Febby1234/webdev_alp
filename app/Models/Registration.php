<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Registration extends Model
{
    protected $fillable = [
        'user_id',
        'major_id',
        'batch_id',
        'registration_code',
        'status',
    ];

    /**
     * Boot method untuk auto-generate registration code
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registration) {
            if (empty($registration->registration_code)) {
                // Generate kode unik: REG-YYYYMMDD-RANDOM8
                $registration->registration_code = 'REG-' . date('Ymd') . '-' . strtoupper(Str::random(8));
            }
        });
    }

    // RELATIONSHIPS

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function personalDetail()
    {
        return $this->hasOne(PersonalDetail::class);
    }

    public function parents()
    {
        return $this->hasOne(ParentData::class);
    }

    public function schoolOrigin()
    {
        return $this->hasOne(SchoolOrigin::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    /**
     * Many-to-Many relationship dengan Schedule
     * 1 registrasi bisa punya banyak jadwal (exam, interview, dll)
     */
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'registration_schedule')
            ->withPivot('attendance')
            ->withTimestamps();
    }

    // HELPER METHODS

    /**
     * Check if all documents are verified
     */
    public function hasAllDocumentsVerified(): bool
    {
        $totalDocs = $this->documents()->count();
        $verifiedDocs = $this->documents()->where('status', 'verified')->count();

        return $totalDocs >= 4 && $totalDocs === $verifiedDocs;
    }

    /**
     * Check if payment is verified
     */
    public function hasPaymentVerified(): bool
    {
        return $this->payment && $this->payment->status === 'verified';
    }

    /**
     * Get registration progress percentage
     */
    public function getProgressPercentage(): int
    {
        $steps = [
            'pending' => 0,
            'documents_pending' => 20,
            'documents_verified' => 40,
            'payment_pending' => 50,
            'paid' => 60,
            'exam_scheduled' => 70,
            'interview_scheduled' => 80,
            'finished' => 90,
            'accepted' => 100,
            'rejected' => 100,
        ];

        return $steps[$this->status] ?? 0;
    }

    /**
     * Get human-readable status
     */
    public function getStatusLabel(): string
    {
        $labels = [
            'pending' => 'Menunggu Pengisian Data',
            'documents_pending' => 'Menunggu Upload Dokumen',
            'documents_verified' => 'Dokumen Terverifikasi',
            'payment_pending' => 'Menunggu Pembayaran',
            'paid' => 'Pembayaran Terverifikasi',
            'exam_scheduled' => 'Terjadwal Ujian',
            'interview_scheduled' => 'Terjadwal Wawancara',
            'finished' => 'Proses Selesai',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
        ];

        return $labels[$this->status] ?? 'Unknown';
    }

    // SCOPES

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByBatch($query, $batchId)
    {
        return $query->where('batch_id', $batchId);
    }

    public function scopeByMajor($query, $majorId)
    {
        return $query->where('major_id', $majorId);
    }
}
