<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('rendicion_abonos', function (Blueprint $table) {
            $table->id('id_rendicion');
            $table->integer('folio');
            $table->datetime('fecha_emision');
            $table->integer('monto_efectivo')->default(0);
            $table->integer('monto_cheque')->default(0);
            $table->integer('monto_transferencia')->default(0);
            $table->integer('monto')->default(0);
            $table->unsignedBigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('estado_id')->default(12); 
            $table->foreign('estado_id')->references('id_estado')->on('estados');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rendicion_abonos');
    }
};
