<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('cover_buku'); // Menyimpan path gambar cover
            $table->string('judul');
            $table->string('penulis');
            $table->text('deskripsi');
            $table->enum('kategori', [
                'fiksi', 'non fiksi', 'keagamaan', 
                'edukasi dan akademik', 'pengembangan diri', 
                'bisnis dan ekonomi', 'seni dan hiburan'
            ]);
            $table->string('file_buku'); // Menyimpan path file PDF
            $table->unsignedBigInteger('views')->default(0); // Menyimpan jumlah view
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('buku');
    }
};

