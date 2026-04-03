@extends('layouts.app')

@section('content')
<div class="container">

<h3>Tambah Kelas</h3>

<form action="{{ route('classrooms.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Nama Kelas</label>
        <input type="text" name="nama_kelas" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Jurusan</label>
        <input type="text" name="jurusan" class="form-control" required>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('classrooms.index') }}" class="btn btn-secondary">Kembali</a>
</form>

</div>
@endsection
