<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Registros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigounico',10);
            $table->unsignedBigInteger('id_tipo_reg');
            $table->foreign('id_tipo_reg')->references('id')->on('c_tipo_registros');
            $table->unsignedBigInteger('id_nivel');
            $table->foreign('id_nivel')->references('id')->on('c_niveles');
            $table->unsignedBigInteger('id_ubicacion');
            $table->foreign('id_ubicacion')->references('id')->on('c_ubicaciones');
            $table->integer('numero')->nullable(true);
            $table->string('nombres')->nullable(true);
            $table->string('paterno')->nullable(true);
            $table->string('materno')->nullable(true);
            $table->date('fecha_deceso')->nullable(true);
            $table->string('imagen')->nullable(true);
            $table->string('ip_usuario')->nullable(true);
            $table->string('nombre_usuario')->nullable(true);
            $table->string('usuario_modificador')->nullable(true);
            $table->softDeletes();
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
        Schema::dropIfExists('registros');
    }
}
