<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    use HasFactory;

    protected $primaryKey = "id_abono";

    protected $fillable = [
            'sku',
            'fecha_emision', 
            'monto', 
            'n_cheque',
            'n_transferencia',
            'titular',
            'fecha_vencimiento',
            'fecha_transaccion',
            'entidad_id',
            'factura_id', 
            'tipo_pago_id',
            'estado_id',
            'solicitud_anulacion',
            'motivo',
            'observacion_anulacion',
            'fecha_anulacion',
            'user_id',
            'user_id_anulacion',
            'rendicion_id'
        ];

    
    public function TipoPago()
    {
        return $this->belongsTo(TipoPago::class, 'tipo_pago_id', 'id_pago');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function UserAnulacion()
    {
        return $this->belongsTo(User::class, 'user_id_anulacion');
    }

    public function EntidadFinanciera()
    {
        return $this->belongsTo(EntidadFinanciera::class, 'entidad_id', 'id_entidad');
    }

    public function Factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id', 'id_factura');
    }

    public function Rendicion()
    {
        return $this->belongsTo(RendicionAbono::class, 'rendicion_id');
    }

    public function Estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

}
