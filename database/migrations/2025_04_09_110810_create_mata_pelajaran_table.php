<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id();

            // Relasi ke subjects (nama mata pelajaran dan nama kelas)
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');

            // Relasi ke users (guru)
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');

            // Relasi ke siswa (banyak siswa)
            $table->json('siswa_ids')->nullable(); // JSON array untuk menyimpan banyak siswa

            // Waktu mulai dan berakhir
            $table->time('waktu_mulai');
            $table->time('waktu_berakhir');

            // Hari
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mata_pelajaran');
    }
};
