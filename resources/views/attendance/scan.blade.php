@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="kiosk">

    <header class="kiosk-header">
        <h1>ABSENSI DIGITAL</h1>
        <p id="modeText">Silakan scan QR Code siswa</p>
    </header>

    <div class="camera-frame">
        <video id="preview"></video>
        <div class="scan-line"></div>
    </div>

    <div id="notif" class="notif d-none"></div>

</div>

<audio id="audioSuccess" src="/sound/hadir.mp3"></audio>
<audio id="audioLate" src="/sound/terlambat.mp3"></audio>
<audio id="audioError" src="/sound/error.mp3"></audio>

<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<script>
let scanner;
let isScanning = true;

// 🔑 STATE MODE
let scanMode  = 'pagi';     // pagi | mapel
let sessionId = null;       // class_sessions.id

scanner = new Instascan.Scanner({
    video: document.getElementById('preview'),
    scanPeriod: 5,
    mirror: false
});

scanner.addListener('scan', function (content) {
    if (!isScanning) return;
    isScanning = false;

    console.log("SCAN:", content);

    // ===================== SCAN QR MAPEL =====================
    if (content.startsWith("MAPEL|")) {

        const parts = content.split("|");

        if (parts.length !== 3) {
            document.getElementById('audioError').play();
            alert("❌ QR MAPEL tidak valid");
            isScanning = true;
            return;
        }

        sessionId = parts[1];
        scanMode  = 'mapel';

        document.getElementById('modeText').innerText =
            "MODE MAPEL AKTIF — Silakan scan QR siswa";

        document.getElementById('audioSuccess').play();
        isScanning = true;
        return;
    }

    // ===================== SCAN QR SISWA =====================
    let payload = {
        mode: scanMode
    };

    if (scanMode === 'mapel') {
        payload.nis = content;
        payload.session_id = sessionId;
    } else {
        payload.qr_code = content;
    }

    fetch("{{ route('scan.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {

        const notif = document.getElementById('notif');
        notif.classList.remove('d-none');

        let audio;

        if (data.status === 'success') {

            notif.className = "notif notif-success";
            notif.innerHTML = `
                <h2>${data.absen_status}</h2>
                <b>${data.nama}</b>
                <span>${data.kelas}</span>
                <small>⏰ ${data.jam}</small>
            `;

            audio = (data.absen_status === 'Terlambat')
                ? document.getElementById('audioLate')
                : document.getElementById('audioSuccess');

        } else {
            notif.className = "notif notif-warning";
            notif.innerHTML = `<h3>${data.message}</h3>`;
            audio = document.getElementById('audioError');
        }

        audio.play();

        audio.onended = () => {
            notif.classList.add('d-none');
            isScanning = true;
        };
    })
    .catch(() => {
        document.getElementById('audioError').play();
        isScanning = true;
    });
});

Instascan.Camera.getCameras().then(cameras => {
    if (cameras.length > 0) {
        const cam = cameras.find(c => c.name.toLowerCase().includes('back')) || cameras[0];
        scanner.start(cam);
    } else {
        alert('Camera tidak ditemukan');
    }
});
</script>

<style>
body {
    margin: 0;
    background: linear-gradient(135deg, #0f172a, #020617);
    font-family: 'Segoe UI', sans-serif;
}

.kiosk {
    height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #fff;
}

.kiosk-header {
    text-align: center;
    margin-bottom: 20px;
}

.camera-frame {
    width: 360px;
    height: 360px;
    border-radius: 24px;
    overflow: hidden;
    border: 4px solid #38bdf8;
}

#preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.notif {
    margin-top: 20px;
    padding: 15px 25px;
    border-radius: 16px;
    text-align: center;
}

.notif-success {
    background: #16a34a;
}

.notif-warning {
    background: #f59e0b;
}

.d-none {
    display: none;
}
</style>
@endsection
