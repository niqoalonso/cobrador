<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('tipo_pagos', function (Blueprint $table) {
            $table->id('id_pago');
            $table->string('nombre');
            $table->timestamps();
        });

        //NO ALTERAR EL ORDEN DE LA MIGRACIÓN YA QUE EL MODULO ABONO DEPENDE DE LA ID INGRESARAS

        DB::table('tipo_pagos')->insert(['nombre' => 'Efectivo']);
        DB::table('tipo_pagos')->insert(['nombre' => 'Cheque']);
        DB::table('tipo_pagos')->insert(['nombre' => 'Transferencia']);
    }

    public function down()
    {
        Schema::dropIfExists('tipo_pagos');
    }
};
