<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_pagos', function (Blueprint $table) {
            $table->id('id');
            $table->string('nombre');
            $table->timestamps();
        });

        DB::table('tipo_pagos')->insert(['nombre' => 'Efectivo']);
        DB::table('tipo_pagos')->insert(['nombre' => 'Cheque']);
        DB::table('tipo_pagos')->insert(['nombre' => 'Transferencia']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TipoPago');
    }
};
