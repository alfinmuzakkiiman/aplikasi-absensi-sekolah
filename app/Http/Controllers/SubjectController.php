<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:subjects',
            'nama_mapel' => 'required'
        ]);

        Subject::create($request->all());
        return redirect()->route('subjects.index')
            ->with('success', 'Mapel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'kode_mapel' => 'required',
            'nama_mapel' => 'required'
        ]);

        $subject->update($request->all());

        return redirect()->route('subjects.index')
            ->with('success', 'Mapel berhasil diupdate!');
    }

    public function destroy($id)
    {
        Subject::destroy($id);
        return redirect()->route('subjects.index')
            ->with('success', 'Mapel berhasil dihapus!');
    }
}
