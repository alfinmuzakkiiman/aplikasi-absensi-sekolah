<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // sementara kosong biar ga error
        $total = 0;
        $hadir = 0;
        $izin  = 0;
        $sakit = 0;
        $alpha = 0;
        $students = [];

        return view('pages.dashboard', compact(
            'total', 'hadir', 'izin', 'sakit', 'alpha', 'students'
        ));
    }

    public function data()
    {
        return response()->json([
            'total' => 0,
            'hadir' => 0,
            'izin'  => 0,
            'sakit' => 0,
            'alpha' => 0,
        ]);
    }
}
