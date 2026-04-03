<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ClassSession;

class Schedule extends Model
{
    protected $fillable = [
        'subject_id',
        'teacher_id',
        'classroom_id',
        'day',
        'start_time',
        'end_time',
        'ruang'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    // 🔥 INI PENTING UNTUK STATUS START
    public function activeSession()
    {
        return $this->hasOne(ClassSession::class)
            ->where('active', true);
    }
}
