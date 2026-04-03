@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Jadwal Pelajaran</h3>

    <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- MAPEL --}}
        <div class="mb-3">
            <label class="form-label">Mapel</label>
            <select name="subject_id" class="form-control" required>
                @foreach($subjects as $s)
                    <option value="{{ $s->id }}"
                        {{ $schedule->subject_id == $s->id ? 'selected' : '' }}>
                        {{ $s->nama_mapel }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- GURU --}}
        <div class="mb-3">
            <label class="form-label">Guru Pengajar</label>
            <select name="teacher_id" class="form-control" required>
                @foreach($teachers as $t)
                    <option value="{{ $t->id }}"
                        {{ $schedule->teacher_id == $t->id ? 'selected' : '' }}>
                        {{ $t->nama }} ({{ $t->mapel }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- KELAS --}}
        <div class="mb-3">
            <label class="form-label">Kelas</label>
            <select name="classroom_id" class="form-control" required>
                @foreach($classrooms as $c)
                    <option value="{{ $c->id }}"
                        {{ $schedule->classroom_id == $c->id ? 'selected' : '' }}>
                        {{ $c->nama_kelas }} - {{ $c->jurusan }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- HARI --}}
        <div class="mb-3">
            <label class="form-label">Hari</label>
            <select name="day" class="form-control" required>
                @php
                    $days = ['Senin','Selasa','Rabu','Kamis','Jumat'];
                @endphp
                @foreach ($days as $d)
                    <option value="{{ $d }}" {{ $schedule->day == $d ? 'selected' : '' }}>
                        {{ $d }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- JAM --}}
        <div class="mb-3">
            <label class="form-label">Jam Mulai</label>
            <input type="time" name="start_time" class="form-control"
                   value="{{ $schedule->start_time }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jam Selesai</label>
            <input type="time" name="end_time" class="form-control"
                   value="{{ $schedule->end_time }}" required>
        </div>

        {{-- RUANG --}}
        <div class="mb-3">
            <label class="form-label">Ruang</label>
            <input type="text" name="ruang" class="form-control"
                   value="{{ $schedule->ruang }}" required>
        </div>

        <button class="btn btn-primary">Update Jadwal</button>
        <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
