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
    Schema::table('essay_exam_results', function (Blueprint $table) {
        $table->unsignedBigInteger('siswa_id')->nullable()->change();
    });
}

public function down()
{
    Schema::table('essay_exam_results', function (Blueprint $table) {
        $table->unsignedBigInteger('siswa_id')->nullable(false)->change();
    });
}

};
