<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('formulir_pendaftaran', function (Blueprint $table) {
            $table->string('berkas_sertifikat')->nullable(); // Kolom untuk file sertifikat
            $table->decimal('nilai_us', 5, 2)->nullable(); // Kolom untuk nilai US
        });
    }

    public function down()
    {
        Schema::table('formulir_pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['berkas_sertifikat', 'nilai_us']);
        });
    }
};
