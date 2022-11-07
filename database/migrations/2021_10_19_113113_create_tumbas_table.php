<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTumbasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tumbas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('ubicacion');
            $table->string('nivel');
            $table->string('numero');
            $table->string('nombres');
            $table->string('ap_paterno');
            $table->string('ap_materno');
            $table->string('fecha_deceso');
            $table->string('imagen');
            $table->text('obs');
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
        Schema::dropIfExists('tumbas');
    }
}
