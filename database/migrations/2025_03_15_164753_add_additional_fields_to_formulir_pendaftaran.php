<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('formulir_pendaftaran', function (Blueprint $table) {
            $table->string('pekerjaan_orangtua')->nullable();
            $table->decimal('penghasilan_orangtua', 15, 2)->nullable();
            $table->decimal('jarak_rumah_sekolah', 5, 2)->nullable(); // dalam km
            $table->string('kendaraan')->nullable();
            $table->string('nama_bapak')->nullable();
        });
    }

    public function down()
    {
        Schema::table('formulir_pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['pekerjaan_orangtua', 'penghasilan_orangtua', 'jarak_rumah_sekolah', 'kendaraan', 'nama_bapak']);
        });
    }
};
