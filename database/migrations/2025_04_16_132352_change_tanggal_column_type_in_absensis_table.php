<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dateTime('tanggal')->change();
        });
    }

    public function down()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->date('tanggal')->change();
        });
    }
};
