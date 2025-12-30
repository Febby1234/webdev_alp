<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'registration_id',
        'type',
        'file_path',
        'status',
        'note',
    ];

    // RELATIONSHIPS

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    // HELPER METHODS

    /**
     * Get file URL
     */
    public function getFileUrl(): string
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Get file extension
     */
    public function getFileExtension(): string
    {
        return pathinfo($this->file_path, PATHINFO_EXTENSION);
    }

    /**
     * Check if file is image
     */
    public function isImage(): bool
    {
        $extension = $this->getFileExtension();
        return in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
    }

    /**
     * Check if file is PDF
     */
    public function isPdf(): bool
    {
        return strtolower($this->getFileExtension()) === 'pdf';
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

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
