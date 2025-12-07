<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = [
        'registration_id',
        'interviewer_id',
        'score',
        'result',
        'notes'
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function interviewer()
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }
}