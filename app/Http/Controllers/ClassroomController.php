<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::latest()->get();
        return view('classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        return view('classrooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'jurusan' => 'required'
        ]);

        Classroom::create($request->all());

        return redirect()->route('classrooms.index')
                         ->with('success', 'Data kelas berhasil ditambahkan');
    }

    public function edit(Classroom $classroom)
    {
        return view('classrooms.edit', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'jurusan'    => 'required'
        ]);

        $classroom->update($request->all());

        return redirect()->route('classrooms.index')
                         ->with('success', 'Data kelas berhasil diperbarui');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return redirect()->route('classrooms.index')
                         ->with('success', 'Data kelas berhasil dihapus');
    }
}
