<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('abonos', function (Blueprint $table) {
            $table->id('id_abono');
            $table->string('sku');
            $table->datetime('fecha_emision');
            $table->integer('monto');
            $table->string('n_cheque')->nullable();
            $table->string('n_transferencia')->nullable();
            $table->string('titular')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->date('fecha_transaccion')->nullable();
            $table->unsignedBigInteger('entidad_id')->nullable();
            $table->foreign('entidad_id')->references('id_entidad')->on('entidad_financieras');
            $table->unsignedBigInteger('factura_id');
            $table->foreign('factura_id')->references('id_factura')->on('facturas');
            $table->unsignedBigInteger('tipo_pago_id');
            $table->foreign('tipo_pago_id')->references('id_pago')->on('tipo_pagos');
            $table->unsignedBigInteger('estado_id');
            $table->foreign('estado_id')->references('id_estado')->on('estados');
            $table->boolean('solicitud_anulacion')->default(0);
            $table->text('motivo')->nullable();
            $table->text('observacion_anulacion')->nullable();
            $table->date('fecha_anulacion')->nullable();
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('abonos');
    }
};
