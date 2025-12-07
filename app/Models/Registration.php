<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'user_id',
        'major_id',
        'batch_id',
        'status',
    ];

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
}