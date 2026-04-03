@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Jadwal Pelajaran</h3>

    <form action="{{ route('schedules.store') }}" method="POST">
        @csrf

        {{-- MAPEL --}}
        <div class="mb-3">
            <label class="form-label">Mapel</label>
            <select name="subject_id" class="form-control" required>
                <option value="">-- Pilih Mapel --</option>
                @foreach($subjects as $s)
                    <option value="{{ $s->id }}">{{ $s->nama_mapel }}</option>
                @endforeach
            </select>
        </div>

        {{-- GURU --}}
        <div class="mb-3">
            <label class="form-label">Guru Pengajar</label>
            <select name="teacher_id" class="form-control" required>
                <option value="">-- Pilih Guru --</option>
                @foreach($teachers as $t)
                    <option value="{{ $t->id }}">
                        {{ $t->nama }} ({{ $t->mapel }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- KELAS --}}
        <div class="mb-3">
            <label class="form-label">Kelas</label>
            <select name="classroom_id" class="form-control" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($classrooms as $c)
                    <option value="{{ $c->id }}">
                        {{ $c->nama_kelas }} - {{ $c->jurusan }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- HARI --}}
        <div class="mb-3">
            <label class="form-label">Hari</label>
            <select name="day" class="form-control" required>
                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $hari)
                    <option value="{{ $hari }}">{{ $hari }}</option>
                @endforeach
            </select>
        </div>

        {{-- JAM --}}
        <div class="mb-3">
            <label class="form-label">Jam Mulai</label>
            <input type="time" name="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jam Selesai</label>
            <input type="time" name="end_time" class="form-control" required>
        </div>

        {{-- RUANG (INPUT MANUAL) --}}
        <div class="mb-3">
            <label class="form-label">Ruang</label>
            <input type="text" name="ruang" class="form-control" placeholder="Contoh: LAB RPL / A12 / A15" required>
        </div>

        <button class="btn btn-success mt-3">Simpan</button>
    </form>
</div>
@endsection
