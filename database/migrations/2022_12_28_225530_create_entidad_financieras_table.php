<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('entidad_financieras', function (Blueprint $table) {
            $table->id('id_entidad');
            $table->string('nombre');
            $table->timestamps();
        });

        DB::table('entidad_financieras')->insert(['nombre' => 'Banco Bice']);
        DB::table('entidad_financieras')->insert(['nombre' => 'BBVA']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Banco Consorcio']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Banco de Chile - Edwards Citi']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Banco Del Desarrollo']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Banco Estado']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Banco Falabella']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Banco Internacional']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Banco Itaú']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Banco Paris']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Banco Ripley']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Banco Santander - Banefe']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Banco Security']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Bci - Tbanc - Nova']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Coopeuch']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Corpbanca']);
        DB::table('entidad_financieras')->insert(['nombre' => 'HSBC Bank']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Los Héroes']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Mercado Pago Emisora S.A']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Scotiabank']);
        DB::table('entidad_financieras')->insert(['nombre' => 'TAPP Caja Los Andes']);
        DB::table('entidad_financieras')->insert(['nombre' => 'TENPO Prepago']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Banco Transbank']);
        DB::table('entidad_financieras')->insert(['nombre' => 'Otra Entidad']);
    }

    public function down()
    {
        Schema::dropIfExists('entidad_financieras');
    }
};
