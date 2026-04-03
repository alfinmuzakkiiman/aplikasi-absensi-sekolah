@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow p-4">
        <h4 class="mb-3 text-center">📚 Scan Absensi Mapel</h4>

        <video id="preview" style="width:100%; border-radius:12px;"></video>

        <div id="notif" class="alert mt-3 d-none"></div>

        <form method="POST" action="{{ route('scan.mapel.store') }}" id="formScan">
            @csrf
            <input type="hidden" name="session_id" id="session_id">
            <input type="hidden" name="token" id="token">
            <input type="hidden" name="nis" id="nis">

            {{-- 🔑 WAJIB: MODE MAPEL --}}
            <input type="hidden" name="mode" value="mapel">
        </form>
    </div>
</div>

{{-- INSTASCAN --}}
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<script>
/**
 * ======================================
 * FINAL SCAN MAPEL + SISWA (STABIL)
 * ======================================
 */

let scanner = new Instascan.Scanner({
    video: document.getElementById('preview'),
    scanPeriod: 5,
    mirror: false
});

let step   = 1; // 1 = MAPEL, 2 = SISWA
let locked = false;

/**
 * NOTIF HELPER
 */
function showNotif(type, text) {
    const notif = document.getElementById('notif');
    notif.className = 'alert alert-' + type + ' mt-3';
    notif.innerHTML = text;
    notif.classList.remove('d-none');
}

/**
 * SCAN EVENT
 */
scanner.addListener('scan', function (rawContent) {
    if (locked) return;
    locked = true;

    console.log('RAW:', rawContent);

    // NORMALISASI QR SISWA
    let content = rawContent;
    if (rawContent.startsWith('SISWA-')) {
        content = rawContent.replace('SISWA-', 'SISWA|');
    }

    console.log('NORMALIZED:', content);

    /**
     * STEP 1 — MAPEL
     * FORMAT: MAPEL|session_id|token
     */
    if (step === 1 && content.startsWith('MAPEL|')) {
        const data = content.split('|');

        if (data.length !== 3) {
            showNotif('warning', '❌ Format QR MAPEL tidak valid');
            locked = false;
            return;
        }

        document.getElementById('session_id').value = data[1];
        document.getElementById('token').value      = data[2];

        showNotif('info', '✅ QR MAPEL diterima<br>📌 Silakan scan QR SISWA');

        step = 2;
        setTimeout(() => locked = false, 1200);
        return;
    }

    /**
     * STEP 2 — SISWA
     * FORMAT: SISWA|NIS
     */
    if (step === 2 && content.startsWith('SISWA|')) {
        const data = content.split('|');

        if (data.length !== 2) {
            showNotif('warning', '❌ Format QR SISWA tidak valid');
            locked = false;
            return;
        }

        document.getElementById('nis').value = data[1];

        showNotif('success', '✅ Absensi berhasil, menyimpan data...');

        document.getElementById('formScan').submit();

        step = 1;
        setTimeout(() => locked = false, 3000);
        return;
    }

    /**
     * SALAH QR / URUTAN
     */
    showNotif('warning', '⚠️ QR tidak valid / urutan salah');
    setTimeout(() => locked = false, 1500);
});

/**
 * START CAMERA
 */
Instascan.Camera.getCameras().then(cameras => {
    if (cameras.length > 0) {
        scanner.start(cameras[0]);
    } else {
        alert('Camera tidak ditemukan');
    }
});
</script>
@endsection
