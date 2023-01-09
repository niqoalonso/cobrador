<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postura extends Model
{
    use HasFactory;

    protected $primarKey = "id_postura";

    protected $fillable = ['fecha_emision', 'total', 'estado_id', 'tipo_pago_id'];
}
