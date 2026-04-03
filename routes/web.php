<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ClassSessionController;
use App\Http\Controllers\ClassSessionAttendanceController;
use App\Http\Controllers\AttendanceMapelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/data', [DashboardController::class, 'data'])->name('dashboard.data');

// Students + QR
Route::resource('students', StudentController::class);
Route::get('/students/{id}/generate-qr', [StudentController::class, 'generateQr'])
    ->name('students.generateQr');

// Teachers
Route::resource('teachers', TeacherController::class);

// Classrooms
Route::resource('classrooms', ClassroomController::class);

// Subjects (mata pelajaran)
Route::resource('subjects', SubjectController::class);

// Schedules (jadwal pelajaran)
Route::resource('schedules', ScheduleController::class);

/*
|--------------------------------------------------------------------------
| CLASS SESSIONS (ABSENSI MAPEL)
|--------------------------------------------------------------------------
*/

// ======================
// SISWA SCAN QR MAPEL
// ======================
Route::get('/scan-mapel', function () {
    return view('attendance.scan_mapel');
})->name('scan.mapel');

Route::post('/scan-mapel',
    [ClassSessionAttendanceController::class, 'store']
)->name('scan.mapel.store');


// ======================
// GURU - SESSION MAPEL
// ======================

// ▶️ GURU MULAI PELAJARAN
Route::post('/sessions/start',
    [ClassSessionController::class, 'start']
)->name('sessions.start');

// 📺 QR MAPEL
Route::get('/sessions/{session}/qr',
    [ClassSessionController::class, 'showQr']
)->name('sessions.qr');

// ⛔ AKHIRI SESI
Route::post('/sessions/{session}/end',
    [ClassSessionController::class, 'end']
)->name('sessions.end');

/*
|--------------------------------------------------------------------------
| ABSENSI MAPEL
|--------------------------------------------------------------------------
*/

Route::get(
    '/attendance-mapel/session/{session_id}',
    [AttendanceMapelController::class, 'show']
)->name('attendance.mapel.show');

Route::get(
    '/scan-mapel/{session}',
    [AttendanceMapelController::class, 'scanMapel']
)->name('scan.mapel.session');




/*
|--------------------------------------------------------------------------
| Scan QR (student)
|--------------------------------------------------------------------------
*/

// Halaman scan kamera
Route::get('/scan-qr', [AttendanceController::class, 'scan'])->name('scan');

// Simpan hasil scan
Route::post('/scan-qr', [AttendanceController::class, 'store'])->name('scan.store');

// Riwayat Absensi
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');


Route::post('/session/attendance', [ClassSessionAttendanceController::class, 'store']);

//pembagian route siswa create berdasarkan kelas
// Pilih kelas dulu sebelum create siswa
Route::get('/students/select-class', [StudentController::class, 'selectClass'])
    ->name('students.selectClass');

// Create siswa berdasarkan kelas yang dipilih
Route::get('/students/create/{kelas}', [StudentController::class, 'createByClass'])
    ->name('students.createByClass');

// Resource siswa, kecuali create & show (karena create kita handle sendiri, show tidak dipakai)
Route::resource('students', StudentController::class)->except(['create', 'show']);


// |-------------------------------------------------------------------------- 
// | ABSENSI MAPEL
// |-------------------------------------------------------------------------- 
// 📊 REKAP JADWAL & ABSENSI MAPEL (INDEX)
Route::get(
    '/rekap-jadwal-absen-mapel',
    [AttendanceMapelController::class, 'index']
)->name('attendance.mapel.rekap');




