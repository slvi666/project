<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengumumanTable extends Migration
{
    public function up()
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul_pengumuman');
            $table->text('isi_pengumuman');
            $table->text('deskripsi_pengumuman')->nullable();
            $table->enum('status', ['aktif', 'non aktif'])->default('aktif');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengumuman');
    }
}
