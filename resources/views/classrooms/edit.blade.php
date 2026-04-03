@extends('layouts.app')

@section('content')
<div class="container">

<h3>Edit Kelas</h3>

<form action="{{ route('classrooms.update',$classroom->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama Kelas</label>
        <input type="text" name="nama_kelas" 
               value="{{ $classroom->nama_kelas }}" 
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Jurusan</label>
        <input type="text" name="jurusan" 
               value="{{ $classroom->jurusan }}" 
               class="form-control" required>
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="{{ route('classrooms.index') }}" class="btn btn-secondary">Kembali</a>
</form>

</div>
@endsection
