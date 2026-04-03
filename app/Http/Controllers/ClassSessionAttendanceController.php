<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSession;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;

class ClassSessionAttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'session_id' => 'required',
            'token'      => 'required',
            'nis'        => 'required'
        ]);

        $session = ClassSession::where('id', $request->session_id)
            ->where('token', $request->token)
            ->where('active', true)
            ->first();

        if (!$session) {
            return back()->with('error', 'QR MAPEL tidak valid');
        }

        $now = Carbon::now();

        if ($now->lt($session->starts_at)) {
            return back()->with('error', 'Absensi belum dimulai');
        }

        if ($now->gt($session->ends_at)) {
            return back()->with('error', 'Waktu absensi sudah berakhir');
        }

        $student = Student::where('nis', $request->nis)->first();

        if (!$student) {
            return back()->with('error', 'Siswa tidak ditemukan');
        }

        $already = Attendance::where('student_id', $student->id)
            ->whereDate('tanggal', $now->toDateString())
            ->exists();

        if ($already) {
            return back()->with('error', 'Sudah absen hari ini');
        }

        Attendance::create([
            'student_id' => $student->id,
            'tanggal'    => $now->toDateString(),
            'jam_masuk'  => $now->format('H:i:s'),
            'status'     => 'Hadir',
        ]);

        return back()->with('success', '✅ Absensi mapel berhasil');
    }
}
