<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'banner_image',
        'user_id',
    ];

    // RELATIONSHIPS

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // HELPER METHODS

    /**
     * Get banner image URL
     */
    public function getBannerUrl(): ?string
    {
        return $this->banner_image ? asset('storage/' . $this->banner_image) : null;
    }

    /**
     * Check if has banner image
     */
    public function hasBanner(): bool
    {
        return !empty($this->banner_image);
    }

    /**
     * Get excerpt (first 150 characters)
     */
    public function getExcerpt(int $length = 150): string
    {
        return strlen($this->content) > $length
            ? substr($this->content, 0, $length) . '...'
            : $this->content;
    }

    /**
     * Get formatted date
     */
    public function getFormattedDate(): string
    {
        return $this->created_at->format('d F Y');
    }

    // SCOPES

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopePublished($query)
    {
        // Jika nanti ada sistem publish/draft, bisa ditambahkan disini
        return $query;
    }
}
