<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Classroom;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with([
            'subject',
            'teacher',
            'classroom',
            'activeSession' // 🔥 STATUS AKTIF
        ])->get();

        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $subjects   = Subject::all();
        $teachers   = Teacher::all();
        $classrooms = Classroom::all();

        return view('schedules.create', compact(
            'subjects',
            'teachers',
            'classrooms'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id'   => 'required',
            'teacher_id'   => 'required',
            'classroom_id' => 'required',
            'day'          => 'required',
            'start_time'   => 'required',
            'end_time'     => 'required',
            'ruang'        => 'required',
        ]);

        Schedule::create($request->only([
            'subject_id',
            'teacher_id',
            'classroom_id',
            'day',
            'start_time',
            'end_time',
            'ruang'
        ]));

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $schedule   = Schedule::findOrFail($id);
        $subjects   = Subject::all();
        $teachers   = Teacher::all();
        $classrooms = Classroom::all();

        return view('schedules.edit', compact(
            'schedule',
            'subjects',
            'teachers',
            'classrooms'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'subject_id'   => 'required',
            'teacher_id'   => 'required',
            'classroom_id' => 'required',
            'day'          => 'required',
            'start_time'   => 'required',
            'end_time'     => 'required',
            'ruang'        => 'required',
        ]);

        Schedule::findOrFail($id)->update($request->only([
            'subject_id',
            'teacher_id',
            'classroom_id',
            'day',
            'start_time',
            'end_time',
            'ruang'
        ]));

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Jadwal berhasil diupdate!');
    }

    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }
}
