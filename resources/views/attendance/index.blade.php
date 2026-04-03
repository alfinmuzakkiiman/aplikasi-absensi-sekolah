@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Absensi Hari Ini</h1>
        <a href="{{ route('scan') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-qrcode"></i> Scan QR
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <strong>{{ now()->format('d F Y') }}</strong>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Jam Masuk</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $a)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $a->student->nama }}</td>
                        <td>{{ $a->student->nis }}</td>
                        <td class="text-center">
                         {{ $a->student->classroom->nama_kelas ?? '-' }}
                        </td>
                        <td>{{ $a->jam_masuk }}</td>
                        <td>
                            @if($a->status == 'Hadir')
                                <span class="badge badge-success">Hadir</span>
                            @else
                                <span class="badge badge-danger">Terlambat</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-muted py-4">
                            Belum ada absensi hari ini
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
