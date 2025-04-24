<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke users
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('set null'); // Relasi ke subjects
            $table->string('nisn')->unique(); // Menambahkan NISN
            $table->string('poto')->nullable(); // Menambahkan foto
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('siswa');
    }
};
