<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * NOTE:
         * - Kolom session_id SUDAH ADA
         * - Foreign key session_id SUDAH ADA
         * 
         * Migration ini dibiarkan KOSONG
         * agar histori migration sinkron dengan DB
         */
    }

    public function down(): void
    {
        /**
         * Tidak rollback apa pun
         * karena ini hanya migration penyesuaian
         */
    }
};
