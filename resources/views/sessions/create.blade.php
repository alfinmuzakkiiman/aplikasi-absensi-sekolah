@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Mulai Sesi - {{ $schedule->subject->nama_mapel ?? 'Mapel' }}</h4>

    <form action="{{ route('sessions.start') }}" method="POST">
        @csrf
        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

        <div class="form-group">
            <label>Durasi (menit)</label>
            <input type="number" name="duration_minutes" class="form-control" value="90" min="5">
        </div>

        <button class="btn btn-primary mt-2">Mulai Sesi (Generate QR)</button>
        <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
