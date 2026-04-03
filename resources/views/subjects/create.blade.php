@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Mapel</h4>

    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Kode Mapel</label>
            <input type="text" name="kode_mapel" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Nama Mapel</label>
            <input type="text" name="nama_mapel" class="form-control" required>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
