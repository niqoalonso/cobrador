<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id('id_factura');
            $table->string('monto_total');
            $table->string('monto_pendiente')->default(0);
            $table->date('fecha_emision');
            $table->string('n_factura');
            $table->unsignedBigInteger('estado_id')->default(9);
            $table->foreign('estado_id')->references('id_estado')->on('estados');
            $table->unsignedBigInteger('arriendo_id');
            $table->foreign('arriendo_id')->references('id_arriendo')->on('arriendos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
    }
};
