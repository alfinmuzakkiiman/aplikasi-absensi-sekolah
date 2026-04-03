<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'session_id', // ⬅️ NULL = pagi, ADA = mapel
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
    ];

    /**
     * 🔗 Relasi ke siswa
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * 🔗 Relasi ke sesi mapel
     * (HANYA untuk absensi mapel)
     */
    public function session()
    {
        return $this->belongsTo(ClassSession::class, 'session_id');
    }
}
