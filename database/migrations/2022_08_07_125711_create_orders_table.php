<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->integer('total');
            $table->smallInteger('status')->default(0)->comment('0:wait for payment 1: pending, 2: done');
            /*
            0 : menunggu pembayarana / konfirmasi user
            1 : sudah dibayar dan barang sedang diproses
            2 : sudah bayar dan barang telah diterima
             */
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
        Schema::dropIfExists('orders');
    }
};
