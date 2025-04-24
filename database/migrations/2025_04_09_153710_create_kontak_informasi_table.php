<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontakInformasiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kontak_informasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_identitas');
            $table->string('email')->nullable();
            $table->string('no_telpon')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('instagram')->nullable();
            $table->string('fb')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontak_informasi');
    }
}
