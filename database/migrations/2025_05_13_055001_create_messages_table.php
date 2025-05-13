<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id'); // Pengirim
            $table->unsignedBigInteger('receiver_id'); // Penerima
            $table->text('message'); // Isi pesan
            $table->timestamp('sent_at')->nullable(); // Waktu pesan dikirim
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade'); // Relasi dengan pengguna
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade'); // Relasi dengan pengguna
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
