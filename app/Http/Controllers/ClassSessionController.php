<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSession;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ClassSessionController extends Controller
{
    /**
     * ▶️ GURU MULAI PELAJARAN
     */
    public function start(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        $schedule = Schedule::with('classroom')->findOrFail($request->schedule_id);

        /**
         * 🔒 CEK:
         * Apakah masih ada session aktif di KELAS YANG SAMA
         */
        $activeSession = ClassSession::whereHas('schedule', function ($q) use ($schedule) {
                $q->where('classroom_id', $schedule->classroom_id);
            })
            ->where('active', true)
            ->first();

        if ($activeSession) {
            return redirect()
                ->route('schedules.index')
                ->with('error', '❌ Masih ada pelajaran lain yang berlangsung di kelas ini');
        }

        // ⏰ JAM SESUAI JADWAL
        $start = Carbon::parse($schedule->start_time);
        $end   = Carbon::parse($schedule->end_time);

        // ✅ BUAT SESSION BARU
        $session = ClassSession::create([
            'schedule_id' => $schedule->id,
            'token'       => strtoupper(Str::random(10)),
            'starts_at'   => $start,
            'ends_at'     => $end,
            'active'      => true,
        ]);

        return redirect()
            ->route('sessions.qr', $session->id)
            ->with('success', '🟢 Pelajaran sedang berlangsung');
    }

    /**
     * 📺 HALAMAN QR MAPEL
     */
   public function showQr(ClassSession $session)
{
    // ⛔ AUTO EXPIRE BERDASARKAN WAKTU
    if ($session->active && now()->gt($session->ends_at)) {
        $session->update([
            'active'  => false,
            'ends_at' => now(),
        ]);
    }

    // 🚫 JIKA SUDAH TIDAK AKTIF
    if (!$session->active) {
        return redirect()
            ->route('schedules.index')
            ->with('error', 'Sesi pelajaran sudah berakhir.');
    }

    $session->load([
        'schedule.subject',
        'schedule.teacher',
        'schedule.classroom',
    ]);

    return view('sessions.qr', compact('session'));
}


    /**
     * ⛔ AKHIRI SESI
     */
    public function end(ClassSession $session)
    {
        $session->update([
            'active'  => false,
            'ends_at' => now(),
        ]);

        return redirect()
            ->route('schedules.index')
            ->with('success', '🔴 Sesi pelajaran diakhiri.');
    }
}
