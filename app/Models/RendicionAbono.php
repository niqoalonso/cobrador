<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendicionAbono extends Model
{
    use HasFactory;

    protected $primaryKey = "id_rendicion";

    protected $fillable = [
                            'folio',
                            'fecha_emision',
                            'monto_efectivo',
                            'monto_cheque',
                            'monto_transferencia',
                            'monto',
                            'user_id',
                            'estado_id'];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }          
                     
    public function Abono()
    {
        return $this->hasMany(Abono::class, 'rendicion_id', 'id_rendicion');
    }
}
