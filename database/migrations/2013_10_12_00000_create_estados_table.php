<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->id('id_estado');
            $table->string('nombre');
            $table->timestamps();
        });

        DB::table('estados')->insert(['nombre' => 'Activo']); // 1
        DB::table('estados')->insert(['nombre' => 'Inactivo']); // 2
        
        DB::table('estados')->insert(['nombre' => 'Disponible']); // 3
        DB::table('estados')->insert(['nombre' => 'No Disponible']); // 4
        //Estados para los arriendos
        DB::table('estados')->insert(['nombre' => 'En Curso']); // 5
        DB::table('estados')->insert(['nombre' => 'No Iniciado']); // 6
        DB::table('estados')->insert(['nombre' => 'Terminado']); // 7
        //Estado Facturacion
        DB::table('estados')->insert(['nombre' => 'Pagado']); // 8
        DB::table('estados')->insert(['nombre' => 'Pendiente Pago']); // 9
        DB::table('estados')->insert(['nombre' => 'Factura Vencida']); // 10

         //Estado Abono & Posturas & Rendición
         DB::table('estados')->insert(['nombre' => 'Rendido']); // 11
         DB::table('estados')->insert(['nombre' => 'No Rendido']); // 12
         DB::table('estados')->insert(['nombre' => 'Anulado']); // 13

    }

    public function down()
    {
        Schema::dropIfExists('estados');
    }
};
