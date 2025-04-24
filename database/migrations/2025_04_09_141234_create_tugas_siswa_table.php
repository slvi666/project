<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tugas_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->string('judul_tugas');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_diberikan');
            $table->date('deadline');
            $table->string('file_soal')->nullable();
            $table->string('file_jawaban')->nullable();
            $table->enum('status', ['belum_dikerjakan', 'sudah_dikumpulkan'])->default('belum_dikerjakan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tugas_siswa');
    }
};
