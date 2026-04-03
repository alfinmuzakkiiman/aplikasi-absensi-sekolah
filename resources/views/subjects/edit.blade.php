@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Mapel</h4>

    <form action="{{ route('subjects.update',$subject->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Kode Mapel</label>
            <input type="text" name="kode_mapel" class="form-control"
                value="{{ $subject->kode_mapel }}" required>
        </div>

        <div class="form-group">
            <label>Nama Mapel</label>
            <input type="text" name="nama_mapel" class="form-control"
                value="{{ $subject->nama_mapel }}" required>
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
