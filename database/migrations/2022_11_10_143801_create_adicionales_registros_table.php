<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdicionalesRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adicionales_registros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_adicionales');
            $table->foreign('id_adicionales')->references('id')->on('c_adicionales');
            $table->unsignedBigInteger('id_registros');
            $table->foreign('id_registros')->references('id')->on('registros');
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
        Schema::dropIfExists('adicionales_registros');
    }
}
