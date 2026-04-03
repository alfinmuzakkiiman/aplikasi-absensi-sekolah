@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Jadwal Pelajaran</h1>
        <a href="{{ route('schedules.create') }}" 
           class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Jadwal
        </a>
    </div>

    <!-- Alert -->
    @foreach (['success','warning','error'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg == 'success' ? 'success' : ($msg == 'warning' ? 'warning' : 'danger') }}">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Jadwal</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-hover" width="100%">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Ruang</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($schedules as $sch)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>

                            <td>
                                <strong>{{ $sch->classroom->nama_kelas ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $sch->classroom->jurusan ?? '' }}</small>
                            </td>

                            <td>{{ $sch->subject->nama_mapel ?? '-' }}</td>
                            <td>{{ $sch->teacher->nama ?? '-' }}</td>

                            <td class="text-center">
                                <span class="badge badge-info">{{ $sch->day }}</span>
                            </td>

                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($sch->start_time)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($sch->end_time)->format('H:i') }}
                            </td>

                            <td class="text-center">
                                {{ $sch->ruang }}
                            </td>

                            <!-- ACTION -->
                            <td class="text-center">

                                @if($sch->activeSession)
                                    <span class="badge badge-success d-block mb-1">
                                        🟢 Sedang berlangsung
                                    </span>

                                    <a href="{{ route('sessions.qr', $sch->activeSession->id) }}"
                                       class="btn btn-warning btn-sm mb-1">
                                        📷 Lihat QR
                                    </a>
                                @else
                                    <form action="{{ route('sessions.start') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="schedule_id" value="{{ $sch->id }}">
                                        <button class="btn btn-success btn-sm mb-1">
                                            ▶️ Mulai
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('schedules.edit', $sch->id) }}"
                                   class="btn btn-info btn-sm mb-1">
                                    ✏️
                                </a>

                                <form action="{{ route('schedules.destroy', $sch->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus jadwal ini?')"
                                            class="btn btn-danger btn-sm mb-1">
                                        🗑️
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">
                                🚫 Belum ada jadwal
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>
    </div>

</div>
@endsection
