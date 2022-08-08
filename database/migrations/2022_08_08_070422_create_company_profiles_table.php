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
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->text("desc");
            $table->string("no_telp");
            $table->string("whatsapp");
            // $table->integer('provinsi')->default(0)
            // $table->integer('kota')->default(0)
            $table->text("alamat");
            $table->string("email");
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
        Schema::dropIfExists('company_profiles');
    }
};
