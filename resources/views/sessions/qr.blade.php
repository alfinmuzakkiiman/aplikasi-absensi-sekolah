@extends('layouts.app')

@section('content')
<div class="container text-center">

    @if($session->active)
        <div class="alert alert-success">
            🟢 <strong>Pelajaran sedang berlangsung</strong><br>
            Silakan siswa scan QR MAPEL
        </div>
    @endif

    

    <h4 class="font-weight-bold mb-1">
        {{ $session->schedule->subject->nama_mapel }}
    </h4>

    <p class="text-muted">
        Kelas {{ $session->schedule->classroom->nama_kelas }} |
        Guru {{ $session->schedule->teacher->nama }}
    </p>

    <div class="card shadow p-4 d-inline-block mb-3">
        <div id="qrcode"></div>
    </div>

    <p>
        ⏰ {{ $session->starts_at->format('H:i') }} —
        {{ $session->ends_at->format('H:i') }}
    </p>

    <form action="{{ route('sessions.end', $session->id) }}" method="POST">
        @csrf
        <button class="btn btn-danger mt-2">
            ⛔ Akhiri Sesi
        </button>
    </form>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    const qrText = "MAPEL|{{ $session->id }}|{{ $session->token }}";


    console.log("QR MAPEL URL:", qrText);

    new QRCode(document.getElementById("qrcode"), {
        text: qrText,
        width: 260,
        height: 260,
        correctLevel: QRCode.CorrectLevel.H
    });
</script>

@endsection
