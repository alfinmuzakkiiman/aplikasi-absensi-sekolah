<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            // =========================
            // RELASI SISWA
            // =========================
            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();

            // =========================
            // ABSENSI MAPEL (OPSIONAL)
            // NULL = ABSEN PAGI
            // ADA = ABSEN MAPEL
            // =========================
            $table->foreignId('session_id')
                ->nullable()
                ->constrained('class_sessions')
                ->nullOnDelete();

            // =========================
            // DATA ABSENSI
            // =========================
            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->enum('status', ['Hadir', 'Terlambat']);

            $table->timestamps();

            // =========================
            // ANTI DOUBLE ABSEN
            // =========================
            $table->unique(
                ['student_id', 'tanggal', 'session_id'],
                'unique_absen_student_date_session'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
