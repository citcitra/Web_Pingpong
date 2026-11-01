<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaitingListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waiting_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id'); // Siapa yang mengantre
            $table->unsignedBigInteger('slot_id'); // Lapangan/jadwal/turnamen yang penuh
            $table->integer('position');          // Urutan antrean (nomor 1, 2, 3, dst.)
            $table->string('status')->default('waiting'); // Status: waiting, approved, atau canceled
            $table->timestamps();

            // Hubungkan dengan tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        }); // Sudah diperbaiki di sini (tidak ada }; lagi)
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waiting_lists');
    }
}
