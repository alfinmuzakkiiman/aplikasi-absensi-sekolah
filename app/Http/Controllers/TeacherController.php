<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::latest()->get();
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama'       => 'required',
        'nip'        => 'nullable',
        'jenis_guru' => 'required',
        'gmail'      => 'nullable|email',
        'alamat'     => 'nullable',
    ]);

    $last = Teacher::latest('id')->first();
    $number = $last ? ((int) substr($last->kode_guru, 5)) + 1 : 1;
    $kodeGuru = 'GURU-' . str_pad($number, 4, '0', STR_PAD_LEFT);

    Teacher::create([
        'kode_guru'  => $kodeGuru,
        'nama'       => $request->nama,
        'nip'        => $request->nip,
        'jenis_guru' => $request->jenis_guru,
        'gmail'      => $request->gmail,
        'alamat'     => $request->alamat,
    ]);

    return redirect()->route('teachers.index')
        ->with('success', 'Data guru berhasil ditambahkan');
}


    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('teachers.edit', compact('teacher'));
    }
public function update(Request $request, $id)
{
    $teacher = Teacher::findOrFail($id);

    $request->validate([
        'nama'       => 'required',
        'nip'        => 'nullable',
        'jenis_guru' => 'required',
        'gmail'      => 'nullable|email',
        'alamat'     => 'nullable',
    ]);

    $teacher->update([
        'nama'       => $request->nama,
        'nip'        => $request->nip,
        'jenis_guru' => $request->jenis_guru,
        'gmail'      => $request->gmail,
        'alamat'     => $request->alamat,
    ]);

    return redirect()->route('teachers.index')
        ->with('success', 'Data guru berhasil diperbarui');
}

    public function destroy($id)
    {
        Teacher::findOrFail($id)->delete();

        return redirect()->route('teachers.index')
            ->with('success', '✅ Data guru berhasil dihapus');
    }
}
