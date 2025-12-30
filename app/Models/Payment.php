<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'registration_id',
        'amount',
        'proof_image',
        'status',
        'note',
        'verified_by',
    ];

    protected $casts = [
        'amount' => 'integer',
    ];

    // RELATIONSHIPS

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // HELPER METHODS

    /**
     * Get proof image URL
     */
    public function getProofUrl(): string
    {
        return asset('storage/' . $this->proof_image);
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmount(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get status label with color
     */
    public function getStatusBadge(): array
    {
        $badges = [
            'pending' => ['label' => 'Menunggu Verifikasi', 'color' => 'warning'],
            'verified' => ['label' => 'Terverifikasi', 'color' => 'success'],
            'rejected' => ['label' => 'Ditolak', 'color' => 'danger'],
        ];

        return $badges[$this->status] ?? ['label' => 'Unknown', 'color' => 'secondary'];
    }

    /**
     * Check if payment is verified
     */
    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    /**
     * Check if payment is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    // SCOPES

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
