<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('schedules', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('subject_id');   // relasi ke mapel
        $table->unsignedBigInteger('teacher_id');   // relasi ke guru (opsional)
        $table->string('day');                      // hari (Senin, Selasa, ...)
        $table->time('start_time');                 // jam mulai
        $table->time('end_time');                   // jam selesai
        $table->string('classroom')->nullable();    // ruang kelas (opsional)
        $table->timestamps();

        $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
    });
}

};
