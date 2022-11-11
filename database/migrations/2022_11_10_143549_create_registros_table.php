<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosTable extends Migration
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
            $table->unsignedBigInteger('id_tipo_reg');
            $table->foreign('id_tipo_reg')->references('id')->on('c_tipo_registros');
            $table->unsignedBigInteger('id_nivel');
            $table->foreign('id_nivel')->references('id')->on('c_niveles');
            $table->integer('numero')->nullable(true);
            $table->string('nombres')->nullable(true);
            $table->string('paterno')->nullable(true);
            $table->string('materno')->nullable(true);
            $table->dateTime('fecha_deceso')->nullable(true);
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
