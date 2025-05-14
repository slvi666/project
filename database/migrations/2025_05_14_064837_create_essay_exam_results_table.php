<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('essay_exam_results', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel exams
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');

            // Relasi ke tabel siswa
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');

            // Soal esai (disimpan langsung di tabel)
            $table->text('question_text');

            // Jawaban siswa
            $table->text('answer_text');

            // Nilai (bisa null jika belum dinilai)
            $table->integer('score')->nullable();

            // Feedback atau komentar dari pengoreksi
            $table->text('feedback')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('essay_exam_results');
    }
};
