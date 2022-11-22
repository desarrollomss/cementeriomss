<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdicionalesRegistros extends Migration
{

    public function up()
    {
        Schema::create('adicionales_registros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('registros_id');
            $table->foreign('registros_id')->references('id')->on('registros');
            $table->unsignedBigInteger('adicionales_id');
            $table->foreign('adicionales_id')->references('id')->on('c_adicionales');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('adicionales_registros');
    }
}
