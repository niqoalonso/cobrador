<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('arriendos', function (Blueprint $table) {
            $table->id('id_arriendo');
            $table->string('sku');
            $table->string('valor_arriendo');
            $table->string('url_contrato');
            $table->string('saldo_a_favor')->default(0);
            $table->string('deuda_pendiente')->default(0);
            $table->date('fecha_inicio');
            $table->date('fecha_termino')->nullable();
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id_empresa')->on('empresas');
            $table->unsignedBigInteger('estado_id');
            $table->foreign('estado_id')->references('id_estado')->on('estados');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('arriendos');
    }
};
