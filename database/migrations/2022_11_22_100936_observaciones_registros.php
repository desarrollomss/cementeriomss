<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ObservacionesRegistros extends Migration
{
    public function up()
    {
        Schema::create('observaciones_registros', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('registros_id');
            $table->foreign('registros_id')->references('id')->on('registros');
            $table->unsignedBigInteger('observaciones_id');
            $table->foreign('observaciones_id')->references('id')->on('c_observaciones');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('observaciones_registros');
    }
}
