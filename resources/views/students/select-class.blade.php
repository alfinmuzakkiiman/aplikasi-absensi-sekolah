@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Pilih Kelas</h3>

    <form id="selectKelasForm">
        <div class="form-group">
            <label>Kelas</label>
            <select class="form-control" id="kelasSelect" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelas as $k)
                    <option value="{{ $k }}">{{ $k }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Lanjutkan</button>
    </form>
</div>

<script>
document.getElementById('selectKelasForm').addEventListener('submit', function(e){
    e.preventDefault();
    let kelas = document.getElementById('kelasSelect').value;
    if(kelas) {
        window.location.href = "/students/create/" + encodeURIComponent(kelas);
    }
});
</script>
@endsection
