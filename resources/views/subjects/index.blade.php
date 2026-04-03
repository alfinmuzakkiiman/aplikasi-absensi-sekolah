@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3"> Data Mata Pelajaran</h4>

    <a href="{{ route('subjects.create') }}" class="btn btn-primary mb-3">
        + Tambah Mapel
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Mapel</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $s)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $s->kode_mapel }}</td>
                        <td>{{ $s->nama_mapel }}</td>
                        <td>
                            <a href="{{ route('subjects.edit',$s->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('subjects.destroy',$s->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Hapus?')"
                                class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4">Belum ada mapel</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
