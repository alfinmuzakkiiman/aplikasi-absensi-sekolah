<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Tambah schedule_id
            $table->foreignId('schedule_id')
                ->nullable()
                ->after('student_id')
                ->constrained('schedules')
                ->nullOnDelete();

            // Tambah subject_id
            $table->foreignId('subject_id')
                ->nullable()
                ->after('schedule_id')
                ->constrained('subjects')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Drop foreign key dulu sebelum drop column
            $table->dropForeign(['schedule_id']);
            $table->dropForeign(['subject_id']);

            $table->dropColumn('schedule_id');
            $table->dropColumn('subject_id');
        });
    }
};
