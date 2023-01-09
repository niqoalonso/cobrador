<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('posturas', function (Blueprint $table) {
            $table->id('id_postura');
            $table->string('fecha_emision');
            $table->string('total');
            $table->unsignedBigInteger('estado_id');
            $table->foreign('estado_id')->references('id_estado')->on('estados');
            $table->unsignedBigInteger('tipo_pago_id');
            $table->foreign('tipo_pago_id')->references('id_pago')->on('tipo_pagos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posturas');
    }
};
