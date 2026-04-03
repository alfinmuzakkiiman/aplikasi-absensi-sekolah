<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

// ✅ Bacon QR Code
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class StudentController extends Controller
{
    // =================== INDEX ===================
    public function index(Request $request)
    {
        $kelasFilter = $request->kelas;

        $students = Student::with('classroom')
            ->when($kelasFilter, function ($query) use ($kelasFilter) {
                $query->whereHas('classroom', function ($q) use ($kelasFilter) {
                    $q->where('nama_kelas', $kelasFilter);
                });
            })
            ->latest()
            ->get();

        // ❗ UI TETAP (string)
        $kelas = Classroom::orderBy('nama_kelas')
            ->pluck('nama_kelas')
            ->toArray();

        return view('students.index', compact('students', 'kelas', 'kelasFilter'));
    }

    // =================== SELECT CLASS ===================
    public function selectClass()
    {
        $kelas = Classroom::orderBy('nama_kelas')
            ->pluck('nama_kelas')
            ->toArray();

        return view('students.select-class', compact('kelas'));
    }

    // =================== CREATE BY CLASS ===================
    public function createByClass($kelas)
    {
        return view('students.create', compact('kelas'));
    }

    public function show($id)
    {
        return redirect()->route('students.index');
    }

    // =================== STORE ===================
    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required',
            'nis'   => 'required|unique:students',
            'kelas' => 'required',
        ]);

        // 🔒 AMAN: cari classroom_id dari nama kelas
        $classroom = Classroom::where('nama_kelas', $request->kelas)->first();

        if (!$classroom) {
            return back()->withErrors([
                'kelas' => '❌ Kelas tidak terdaftar di Data Kelas'
            ]);
        }

        $qrCode = 'SISWA-' . strtoupper(Str::random(12));

        $student = Student::create([
            'nama'         => $request->nama,
            'nis'          => $request->nis,
            'classroom_id' => $classroom->id,
            'qr_code'      => $qrCode
        ]);

        $this->generateQrImage($student);

        return redirect()->route('students.index')
            ->with('success', '✅ Siswa berhasil ditambahkan');
    }

    // =================== EDIT ===================
    public function edit($id)
    {
        $student = Student::with('classroom')->findOrFail($id);
        return view('students.edit', compact('student'));
    }

    // =================== UPDATE ===================
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'nama'  => 'required',
            'nis'   => 'required|unique:students,nis,' . $id,
            'kelas' => 'required',
        ]);

        $classroom = Classroom::where('nama_kelas', $request->kelas)->first();

        if (!$classroom) {
            return back()->withErrors([
                'kelas' => '❌ Kelas tidak terdaftar di Data Kelas'
            ]);
        }

        $student->update([
            'nama'         => $request->nama,
            'nis'          => $request->nis,
            'classroom_id' => $classroom->id,
        ]);

        return redirect()->route('students.index')
            ->with('success', '✅ Data siswa berhasil diupdate');
    }

    // =================== DELETE ===================
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        if ($student->qr_image && File::exists(public_path($student->qr_image))) {
            File::delete(public_path($student->qr_image));
        }

        $student->delete();

        return redirect()->route('students.index')
            ->with('success', '✅ Data siswa berhasil dihapus');
    }

    // =================== GENERATE QR ===================
    public function generateQr($id)
    {
        $student = Student::findOrFail($id);

        if (!$student->qr_code) {
            $student->update([
                'qr_code' => 'SISWA-' . strtoupper(Str::random(12))
            ]);
        }

        $this->generateQrImage($student);

        return redirect()->route('students.index')
            ->with('success', '✅ QR Code berhasil dibuat ulang');
    }

    // =================== QR IMAGE ===================
    private function generateQrImage($student)
    {
        $folder = public_path('qrcodes');

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        $fileName = 'qr_' . $student->id . '.svg';
        $filePath = $folder . '/' . $fileName;

        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $writer->writeFile($student->qr_code, $filePath);

        $student->update([
            'qr_image' => 'qrcodes/' . $fileName
        ]);
    }
}
