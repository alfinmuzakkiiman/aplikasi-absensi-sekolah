@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-1">
        📘 {{ $session->schedule->subject->nama_mapel }}
    </h3>

    <p class="text-muted">
        {{ $session->schedule->teacher->nama }}
        | {{ $session->schedule->classroom->nama_kelas }}
    </p>

    <p>
        🗓️ {{ \Carbon\Carbon::parse($session->tanggal)->translatedFormat('d F Y') }}
    </p>

    <hr>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Jam Absen</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendances as $absen)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $absen->student->nama }}</td>
                    <td>{{ $absen->student->nis }}</td>
                    <td>{{ $absen->jam_masuk }}</td>
                    <td>
                        <span class="badge bg-success">
                            {{ $absen->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Belum ada siswa absen
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
