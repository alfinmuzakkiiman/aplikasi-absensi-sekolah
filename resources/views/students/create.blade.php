@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Tambah Siswa - {{ $kelas }}
    </h1>

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('students.store') }}" method="POST">
                @csrf

                {{-- SIMPAN NAMA KELAS (controller yang cari classroom_id) --}}
                <input type="hidden" name="kelas" value="{{ $kelas }}">

                <div class="form-group">
                    <label>Nama Siswa</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>NIS</label>
                    <input type="text" name="nis" class="form-control" required>
                </div>

                <button class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>

                <a href="{{ route('students.selectClass') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </form>

        </div>
    </div>
</div>
@endsection
