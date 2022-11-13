<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RegistrosObservaciones extends Migration
{
    public function up()
    {
        Schema::create('registros_observaciones', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_registros');
            $table->foreign('id_registros')->references('id')->on('registros');
            $table->unsignedBigInteger('id_observaciones');
            $table->foreign('id_observaciones')->references('id')->on('c_observaciones');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registros_observaciones');
    }
}