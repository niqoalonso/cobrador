<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('item_postura_posturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_postura_id_postura'); //Para laravel, esta FK deberia llamare nombredetablasingular_primarykeydelafk ej: arriendo_id_arriendo, si no se sigue esta estructura, hay que especificar en la relación esta modificacion.
            $table->foreign('item_postura_id_postura')->references('id_item_postura')->on('item_posturas');
            $table->unsignedBigInteger('postura_id_postura'); //Para laravel, esta FK deberia llamare nombredetablasingular_primarykeydelafk ej: arriendo_id_arriendo, si no se sigue esta estructura, hay que especificar en la relación esta modificacion.
            $table->foreign('postura_id_postura')->references('id_postura')->on('posturas');
            $table->string('cantidad');
            $table->string('valor_unitario');
            $table->string('total');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('item_postura_posturas');
    }
};
