<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassSession;
use Illuminate\Http\Request;

class AttendanceMapelController extends Controller
{
    /**
     * 📚 REKAP JADWAL & ABSENSI MAPEL (INDEX)
     */
    public function index()
    {
        $sessions = ClassSession::with([
            'schedule.subject',
            'schedule.teacher',
            'schedule.classroom'
        ])
        ->whereHas('attendances') // hanya yang sudah ada absen
        ->withCount([
            'attendances as total_hadir' => function ($q) {
                $q->where('status', 'Hadir');
            }
        ])
        ->orderBy('starts_at', 'desc')
        ->get();

        return view('attendance_mapel.index', compact('sessions'));
    }

    /**
     * 🟢 SCAN QR MAPEL
     */
    public function scanMapel(Request $request, $session_id)
    {
        $token = $request->query('token');

        if (!$token) {
            abort(403, '❌ Token mapel tidak ditemukan');
        }

        $session = ClassSession::where('id', $session_id)
            ->where('token', $token)
            ->where('active', true)
            ->first();

        if (!$session) {
            abort(403, '❌ QR Mapel tidak valid atau sesi telah berakhir');
        }

        if (now()->gt($session->ends_at)) {
            $session->update([
                'active'  => false,
                'ends_at' => now(),
            ]);

            abort(403, '⛔ Sesi pelajaran telah berakhir');
        }

        session([
            'mode'                => 'mapel',
            'active_session_id'   => $session->id,
            'active_classroom_id' => $session->schedule->classroom_id
        ]);

        return redirect()->route('scan');
    }

    /**
     * 📘 REKAP ABSENSI MAPEL (DETAIL)
     */
    public function show($session_id)
    {
        $session = ClassSession::with([
            'schedule.subject',
            'schedule.teacher',
            'schedule.classroom'
        ])->findOrFail($session_id);

        $attendances = Attendance::with('student')
            ->where('session_id', $session_id)
            ->orderBy('jam_masuk', 'asc')
            ->get();

        return view('attendance_mapel.show', compact(
            'session',
            'attendances'
        ));
    }
}
