<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {

            /**
             * 1️⃣ KODE GURU
             * Kolom SUDAH ADA → JANGAN ditambah lagi
             * Kita hanya pasang UNIQUE constraint
             */
            $table->unique('kode_guru');

            /**
             * 2️⃣ NIP JADI OPSIONAL
             * Aman karena data lama tetap ada
             */
            $table->string('nip')->nullable()->change();

            /**
             * 3️⃣ JENIS GURU
             * Tambah hanya kalau belum ada
             */
            if (!Schema::hasColumn('teachers', 'jenis_guru')) {
                $table->enum('jenis_guru', ['pns', 'honorer', 'industri'])
                      ->default('honorer')
                      ->after('nip');
            }

            /**
             * 4️⃣ HAPUS MAPEL
             * Karena mapel sekarang lewat subject / jadwal
             */
            if (Schema::hasColumn('teachers', 'mapel')) {
                $table->dropColumn('mapel');
            }
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {

            // Lepas UNIQUE kode_guru
            $table->dropUnique(['kode_guru']);

            // Hapus jenis_guru jika ada
            if (Schema::hasColumn('teachers', 'jenis_guru')) {
                $table->dropColumn('jenis_guru');
            }

            // Kembalikan kolom mapel (opsional)
            if (!Schema::hasColumn('teachers', 'mapel')) {
                $table->string('mapel')->nullable();
            }

            // Kembalikan nip jadi wajib
            $table->string('nip')->nullable(false)->change();
        });
    }
};
