<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id('id_empresa');
            $table->string('sku');
            $table->string('rut');
            $table->string('razon_social');
            $table->string('nombre_fantasia');
            $table->string('correo');
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->boolean('solicita_fac_email')->default(0);
            $table->string('alias');
            $table->string('url_perfil')->nullable();
            $table->unsignedBigInteger('representante_id');
            $table->foreign('representante_id')->references('id_representante')->on('representantes');
            $table->unsignedBigInteger('estado_id')->default(1);
            $table->foreign('estado_id')->references('id_estado')->on('estados');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresas');
    }
};
