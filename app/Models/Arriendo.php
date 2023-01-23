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
            'estado_id',
            'empresa_id'
    ];

    public function Local()
    {
        return $this->belongsToMany(Local::class);
    } 

    public function Empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    } 

    public function Factura()
    {
        return $this->hasMany(Factura::class, 'arriendo_id', 'id_arriendo');
    }

    public function Postura()
    {
        return $this->hasMany(Postura::class, 'arriendo_id', 'id_arriendo');
    }

    public function PosturaNORendidas()
    {
        return $this->hasMany(Postura::class, 'arriendo_id', 'id_arriendo')->where('estado_id', 12);
    }

    public function FacturaPendientes()
    {
        return $this->hasMany(Factura::class, 'arriendo_id', 'id_arriendo')->where('estado_id', '=', 9);
    }
}
