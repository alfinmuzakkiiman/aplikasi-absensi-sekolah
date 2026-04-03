<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {

            // HAPUS kolom 'classroom' yang SALAH
            if (Schema::hasColumn('schedules', 'classroom')) {
                $table->dropColumn('classroom');
            }

            // TAMBAHKAN kolom 'ruang' yang BENAR
            if (!Schema::hasColumn('schedules', 'ruang')) {
                $table->string('ruang')->nullable()->after('classroom_id');
            }
        });
    }

    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->string('classroom')->nullable();
            $table->dropColumn('ruang');
        });
    }
};
