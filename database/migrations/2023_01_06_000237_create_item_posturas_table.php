<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('item_posturas', function (Blueprint $table) {
            $table->id('id_item_postura');
            $table->string('nombre');
            $table->integer('valor')->nullable();
            $table->timestamps();
        });

        DB::table('item_posturas')->insert(['nombre' => 'Camión', 'valor' => 4000]);
        DB::table('item_posturas')->insert(['nombre' => 'Camión con carro', 'valor' => 10000]);
        DB::table('item_posturas')->insert(['nombre' => 'Solo Carro', 'valor' => 6000]);
        DB::table('item_posturas')->insert(['nombre' => 'Bin', 'valor' => 2000]);
        DB::table('item_posturas')->insert(['nombre' => 'Pallet', 'valor' => 2000]);
        DB::table('item_posturas')->insert(['nombre' => 'Otros']);
    }

    public function down()
    {
        Schema::dropIfExists('item_posturas');
    }
};
