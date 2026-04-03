@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Siswa</h1>

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('students.update',$student->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama Siswa</label>
                    <input type="text" name="nama" value="{{ $student->nama }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>NIS</label>
                    <input type="text" name="nis" value="{{ $student->nis }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas" class="form-control" required>
                        <option>{{ $student->kelas }}</option>
                        <option>X RPL</option>
                        <option>XI RPL</option>
                        <option>XII RPL</option>
                        <option>X PHT</option>
                        <option>XI PHT</option>
                        <option>XII PHT</option>
                        <option>X TKR</option>
                        <option>XI TKR</option>
                        <option>XII TKR</option>
                        <option>X PBS</option>
                        <option>XI PBS</option>
                        <option>XII PBS</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save"></i> Update
                </button>

                <a href="{{ route('students.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>
@endsection
