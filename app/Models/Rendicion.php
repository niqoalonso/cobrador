<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rendicion extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_rendicion';

    protected $fillable = [ 'fecha_emision',
                            'monto_postura',
                            'monto_abono',
                            'monto_estacionamiento',
                            'estado_id',
                            'user_id'];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
