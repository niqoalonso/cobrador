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
            $table->integer('sku');
            $table->unsignedBigInteger('arriendo_id');
            $table->foreign('arriendo_id')->references('id_arriendo')->on('arriendos');
            $table->string('fecha_emision');
            $table->string('total');
            $table->unsignedBigInteger('estado_id');
            $table->foreign('estado_id')->references('id_estado')->on('estados');
            $table->unsignedBigInteger('tipo_pago_id');
            $table->foreign('tipo_pago_id')->references('id_pago')->on('tipo_pagos');
            $table->boolean('solicitud_anulacion')->default(0); //Si esta en 1 debe ver esto el tesorero o administrador
            $table->text('motivo')->nullable(); 
            $table->text('observacion_anulacion')->nullable(); //Observación la puede agregar tesorero o administrador
            $table->date('fecha_anulacion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posturas');
    }
};
