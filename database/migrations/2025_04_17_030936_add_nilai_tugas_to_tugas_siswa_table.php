<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tugas_siswa', function (Blueprint $table) {
            $table->integer('nilai_tugas')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('tugas_siswa', function (Blueprint $table) {
            $table->dropColumn('nilai_tugas');
        });
    }
};
