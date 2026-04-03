@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">📚 Rekap Jadwal & Absensi Mapel</h4>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Mapel</th>
                <th>Guru</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Total Hadir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sessions as $s)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $s->schedule->subject->nama_mapel }}</td>

                <td>{{ $s->schedule->teacher->nama }}</td>

                <td>
                    <span class="badge bg-info">
                        {{ $s->schedule->classroom->nama_kelas }}
                    </span>
                </td>

                <td>
                    {{ $s->starts_at->translatedFormat('d F Y') }}
                </td>

                <td>
                    {{ $s->starts_at->format('H:i') }} -
                    {{ $s->ends_at->format('H:i') }}
                </td>

                <td class="text-center">
                    <span class="badge bg-success">
                        {{ $s->total_hadir }} siswa
                    </span>
                </td>

                <td>
                    <a href="{{ route('attendance.mapel.show', $s->id) }}"
                       class="btn btn-sm btn-primary">
                        Lihat
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
