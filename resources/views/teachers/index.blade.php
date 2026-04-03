@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Guru</h1>
        <a href="{{ route('teachers.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Guru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>Kode Guru</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Jenis</th>
                        <th>Gmail</th>
                        <th>Alamat</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($teachers as $t)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center"><strong>{{ $t->kode_guru }}</strong></td>
                        <td>{{ $t->nama }}</td>
                        <td class="text-center">{{ $t->nip ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge badge-info">{{ strtoupper($t->jenis_guru) }}</span>
                        </td>
                        <td>{{ $t->email ?? '-' }}</td>
                        <td>{{ $t->alamat ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('teachers.edit',$t->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('teachers.destroy',$t->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Yakin?')" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
