<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $primaryKey = "id_empresa";

    protected $fillable = [
            'rut',
            'razon_social',
            'nombre_fantasia',
            'correo',
            'telefono',
            'celular',
            'solcicita_fac_email',
            'alias',
            'url_perfil',
            'estado_id',
    ];
}
