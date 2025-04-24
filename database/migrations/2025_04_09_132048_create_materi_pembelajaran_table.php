<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('materi_pembelajaran', function (Blueprint $table) {
            $table->id();

            // Relasi ke user (guru)
            $table->unsignedBigInteger('guru_id');
            $table->foreign('guru_id')->references('id')->on('users')->onDelete('cascade');

            // Relasi ke subject
            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

            // Upload file PDF
            $table->string('file'); // nama file PDF

            // Deskripsi
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materi_pembelajaran');
    }
};
