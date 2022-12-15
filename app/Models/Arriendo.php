<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arriendo extends Model
{
    use HasFactory;

    protected $primaryKey = "id_arriendo";

    protected $fillable = [
            'sku',
            'valor_arriendo',
            'representante_id',
            'url_contrato',
            'saldo_a_favor',
            'deuda_pendiente',
            'fecha_inicio',
            'fecha_termino',
            'representante_id',
            'estado_id',
            'empresa_id'
    ];

    public function Local()
    {
        return $this->belongsToMany(Local::class);
    }
}
