@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Guru</h3>

    <form action="{{ route('teachers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Guru</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>NIP <small class="text-muted">(opsional)</small></label>
            <input type="text" name="nip" class="form-control">
        </div>

        <div class="mb-3">
            <label>Jenis Guru</label>
            <select name="jenis_guru" class="form-control" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="pns">PNS</option>
                <option value="honorer">HONORER</option>
                <option value="industri">INDUSTRI</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Gmail <small class="text-muted">(opsional)</small></label>
            <input type="email" name="gmail" class="form-control"
                   placeholder="guru@gmail.com">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
