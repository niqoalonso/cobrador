<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('locals', function (Blueprint $table) {
            $table->id('id_local');
            $table->string('identificador');//Idenfiticador interno.
            $table->string('direccion');
            $table->unsignedBigInteger('estado_id');
            $table->foreign('estado_id')->references('id_estado')->on('estados');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('locals');
    }
};
