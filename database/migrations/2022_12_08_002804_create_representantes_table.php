<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('representantes', function (Blueprint $table) {
            $table->id('id_representante');
            $table->string('rut');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('correo');
            $table->string('celular');
            $table->unsignedBigInteger('estado_id');
            $table->foreign('estado_id')->references('id_estado')->on('estados');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('representantes');
    }
};
