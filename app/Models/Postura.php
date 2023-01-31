<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postura extends Model
{
    use HasFactory;

    protected $primaryKey = "id_postura";

    protected $fillable = ['sku','fecha_emision', 'total', 'estado_id', 'tipo_pago_id', 'arriendo_id', 'solicitud_anulacion', 'motivo', 'observacion_anulacion', 'fecha_anulacion', 'user_id', 'user_id_anulacion', 'rendicion_id'];


    public function Arriendo()
    {
        return $this->belongsTo(Arriendo::class, 'arriendo_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function UserAnulacion()
    {
        return $this->belongsTo(User::class, 'user_id_anulacion');
    }

    public function DetallePostura()
    {
        return $this->hasMany(DetallePostura::class, 'postura_id', 'id_postura');
    }

    public function TipoPago()
    {
        return $this->belongsTo(TipoPago::class, 'tipo_pago_id');
    }

    public function Rendicion()
    {
        return $this->belongsTo(Rendicion::class, 'rendicion_id');
    }
}
