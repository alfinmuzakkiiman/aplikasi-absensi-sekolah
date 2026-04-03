@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Guru</h3>

    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
        @csrf
        @method('PUT')


        <div class="mb-3">
            <label>Nama Guru</label>
            <input type="text" name="nama"
                   value="{{ $teacher->nama }}"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label>NIP <small class="text-muted">(opsional)</small></label>
            <input type="text" name="nip"
                   value="{{ $teacher->nip }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Jenis Guru</label>
            <select name="jenis_guru" class="form-control" required>
                @foreach (['pns','honorer','industri'] as $j)
                    <option value="{{ $j }}"
                        {{ $teacher->jenis_guru === $j ? 'selected' : '' }}>
                        {{ strtoupper($j) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Gmail</label>
            <input type="email" name="gmail"
                   value="{{ $teacher->gmail }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control">{{ $teacher->alamat }}</textarea>
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
