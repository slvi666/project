<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('formulir_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('nik')->unique();
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('agama');
            $table->string('no_hp');
            $table->text('alamat');
            $table->string('nama_orangtua');
            $table->string('asal_sekolah');
            $table->year('tahun_lulus');
            $table->enum('status', ['Pending', 'Tidak Lulus', 'Lulus'])->default('Pending');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('formulir_pendaftaran');
    }
};
