<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('seleksi_berkas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('formulir_pendaftaran_id');
            $table->string('poto_ktp_orang_tua')->nullable();
            $table->string('kartu_keluarga')->nullable();
            $table->string('akte_kelahiran')->nullable();
            $table->string('surat_kelulusan')->nullable();
            $table->string('raport')->nullable();
            $table->string('kis_kip')->nullable();
            $table->string('ijazah')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('formulir_pendaftaran_id')->references('id')->on('formulir_pendaftaran')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('seleksi_berkas');
    }
};
