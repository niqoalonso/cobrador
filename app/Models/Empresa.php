<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $primaryKey = "id_empresa";

    protected $fillable = [
            'sku',
            'rut',
            'razon_social',
            'nombre_fantasia',
            'correo',
            'telefono',
            'celular',
            'solicita_fac_email',
            'alias',
            'url_perfil',
            'estado_id', 
            'representante_id',
            'estado_id'
    ];

    public function Representante()
    {
        return $this->belongsTo(Representante::class, 'representante_id');
    }

    public function Estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function AllArriendo() //Condidera los arriendo que ya han estado terminados
    {
        return $this->hasMany(Arriendo::class, 'empresa_id', 'id_empresa');
    }

    public function Arriendo() //Concidera solo arriendo vigentes y en curso.
    {
        return $this->hasMany(Arriendo::class, 'empresa_id', 'id_empresa')->where('estado_id', 5);
    }
}
