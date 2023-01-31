<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $primaryKey = "id_factura";

    protected $fillable = ['monto_total', 'monto_pendiente', 'fecha_emision', 'n_factura', 'estado_id', 'arriendo_id'];

    
    public function Arriendo()
    {
        return $this->belongsTo(Arriendo::class, 'arriendo_id');
    }

}
