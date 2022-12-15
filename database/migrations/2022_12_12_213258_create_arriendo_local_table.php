<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('arriendo_local', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('arriendo_id_arriendo'); //Para laravel, esta FK deberia llamare nombredetablasingular_primarykeydelafk ej: arriendo_id_arriendo, si no se sigue esta estructura, hay que especificar en la relación esta modificacion.
            $table->foreign('arriendo_id_arriendo')->references('id_arriendo')->on('arriendos');
            $table->unsignedBigInteger('local_id_local');
            $table->foreign('local_id_local')->references('id_local')->on('locals');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('arriendo_local');
    }
};
