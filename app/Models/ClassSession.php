<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSession extends Model
{
    protected $fillable = [
        'teacher_id',
        'schedule_id',
        'token',
        'starts_at',
        'ends_at',
        'active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
        'active'    => 'boolean',
    ];

    // 🔗 Guru yang mengajar
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // 🔗 Jadwal
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    // 🔗 Absensi siswa
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'session_id');
    }
}
