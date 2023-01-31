<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('detalle_posturas', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->unsignedBigInteger('postura_id'); 
            $table->foreign('postura_id')->references('id_postura')->on('posturas');
            $table->unsignedBigInteger('item_postura_id');
            $table->foreign('item_postura_id')->references('id_item_postura')->on('item_posturas');
            $table->string('cantidad');
            $table->string('valor_unitario');
            $table->string('total');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_posturas');
    }
};
