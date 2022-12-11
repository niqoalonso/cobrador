<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representante extends Model
{
    use HasFactory;

    protected $primaryKey = "id_representante";

    protected $fillable = [
            'rut',
            'nombres',
            'apellidos',
            'correo',
            'celular',
            'estado_id'
    ];
}
