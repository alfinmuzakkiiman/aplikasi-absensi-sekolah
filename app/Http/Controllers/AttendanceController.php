<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\ClassSession;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // ============================
    // HALAMAN SCAN
    // ============================
    public function scan()
    {
        return view('attendance.scan');
    }

    // ============================
    // SIMPAN ABSENSI (PAGI / MAPEL)
    // ============================
    public function store(Request $request)
    {
        dd($request->all());

        $request->validate([
            'mode' => 'required|in:pagi,mapel'
        ]);

        $now     = Carbon::now();
        $tanggal = $now->toDateString();

        /*
        |------------------------------------------------------------------
        | 🟩 MODE MAPEL
        |------------------------------------------------------------------
        */
        if ($request->mode === 'mapel') {

            $request->validate([
                'nis' => 'required'
            ]);

            // 🔎 Cari siswa
            $student = Student::where('nis', $request->nis)->first();

            if (!$student) {
                return response()->json([
                    'status'  => 'error',
                    'message' => '❌ Siswa tidak ditemukan'
                ]);
            }

            // 🔥 AMBIL SESSION AKTIF HARI INI
            $session = ClassSession::where('active', 1)
                ->whereDate('starts_at', $tanggal)
                ->first();

            if (!$session) {
                return response()->json([
                    'status'  => 'error',
                    'message' => '❌ Tidak ada sesi mapel aktif'
                ]);
            }

            // 🚫 Cegah double absen mapel
            $exists = Attendance::where('student_id', $student->id)
                ->where('session_id', $session->id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status'  => 'error',
                    'message' => '⚠️ Sudah absen mapel ini'
                ]);
            }

            Attendance::create([
                'student_id' => $student->id,
                'session_id' => $session->id,
                'tanggal'    => $tanggal,
                'jam_masuk'  => $now->format('H:i:s'),
                'status'     => 'Hadir'
            ]);

            return response()->json([
                'status' => 'success',
                'mode'   => 'mapel',
                'nama'   => $student->nama,
                'kelas'  => $student->kelas,
                'jam'    => $now->format('H:i')
            ]);
        }

        /*
        |------------------------------------------------------------------
        | 🟦 MODE PAGI
        |------------------------------------------------------------------
        */
        $request->validate([
            'qr_code' => 'required'
        ]);

        $student = Student::where('qr_code', $request->qr_code)->first();

        if (!$student) {
            return response()->json([
                'status'  => 'error',
                'message' => '❌ QR tidak valid'
            ]);
        }

        // 🚫 Cegah double absen pagi
        $exists = Attendance::where('student_id', $student->id)
            ->whereDate('tanggal', $tanggal)
            ->whereNull('session_id')
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => 'error',
                'message' => '⚠️ Sudah absen hari ini'
            ]);
        }

        // ⏰ Logic terlambat
        $jamSekolah = Carbon::today()->setTime(7, 0, 0);
        $status     = $now->greaterThan($jamSekolah) ? 'Terlambat' : 'Hadir';

        Attendance::create([
            'student_id' => $student->id,
            'tanggal'    => $tanggal,
            'jam_masuk'  => $now->format('H:i:s'),
            'status'     => $status,
            'session_id' => null
        ]);

        return response()->json([
            'status' => 'success',
            'mode'   => 'pagi',
            'nama'   => $student->nama,
            'kelas'  => $student->kelas,
            'jam'    => $now->format('H:i')
        ]);
    }

    // ============================
    // ABSENSI PAGI HARI INI
    // ============================
    public function index()
    {
        $today = Carbon::today()->toDateString();

        $attendances = Attendance::with('student.classroom')
            ->whereNull('session_id')
            ->whereDate('tanggal', $today)
            ->orderBy('jam_masuk', 'asc')
            ->get();

        return view('attendance.index', compact('attendances'));
    }
}
