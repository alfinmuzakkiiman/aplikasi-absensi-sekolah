@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Siswa</h1>

        @if($kelasFilter)
            <a href="{{ route('students.createByClass', $kelasFilter) }}" 
               class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Siswa
            </a>
        @endif
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- FILTER KELAS -->
    <div class="mb-3">
        <form action="{{ route('students.index') }}" method="GET" class="form-inline">
            <label class="mr-2 font-weight-bold">Pilih Kelas:</label>
            <select name="kelas" class="form-control mr-2">
                <option value="">-- Semua Kelas --</option>
                @foreach($kelas as $k)
                    <option value="{{ $k }}" {{ ($kelasFilter ?? '') == $k ? 'selected' : '' }}>
                        {{ $k }}
                    </option>
                @endforeach
            </select>
            <button class="btn btn-primary btn-sm">Filter</button>
        </form>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Tabel Siswa {{ $kelasFilter ? "Kelas $kelasFilter" : '' }}
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th width="160">QR Code</th>
                            <th width="230">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $s)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><strong>{{ $s->nama }}</strong></td>
                            <td class="text-center">{{ $s->nis }}</td>

                            {{-- 🔥 RELASI BENAR --}}
                            <td class="text-center">
                                <span class="badge badge-info">
                                    {{ $s->classroom->nama_kelas ?? '-' }}
                                </span>
                            </td>

                            <td class="text-center">
                                @if($s->qr_image)
                                    <img src="{{ asset($s->qr_image) }}" width="110" class="img-thumbnail mb-1">
                                    <br>
                                    <small class="badge badge-success">{{ $s->qr_code }}</small>
                                @else
                                    <span class="badge badge-danger">Belum ada QR</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('students.generateQr', $s->id) }}" class="btn btn-warning btn-sm mb-1">
                                    <i class="fas fa-qrcode"></i>
                                </a>
                                <a href="{{ route('students.edit', $s->id) }}" class="btn btn-info btn-sm mb-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('students.destroy', $s->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm mb-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                🚫 Belum ada data siswa
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
