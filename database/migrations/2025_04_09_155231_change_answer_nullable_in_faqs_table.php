<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAnswerNullableInFaqsTable extends Migration
{
    public function up()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->text('answer')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->text('answer')->nullable(false)->change();
        });
    }
}
