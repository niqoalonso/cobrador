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
            $table->string('rut');
            $table->string('razon_social');
            $table->string('nombre_fantasia');
            $table->string('correo');
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->boolean('solicita_fac_email')->default(0);
            $table->string('alias');
            $table->string('url_perfil')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresas');
    }
};
