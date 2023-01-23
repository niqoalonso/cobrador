<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePostura extends Model
{
    use HasFactory;

    protected $primaryKey = "id_detalle";

    protected $fillable = ['postura_id', 'item_postura_id', 'cantidad', 'valor_unitario', 'total'];

    public function ItemPostura()
    {
        return $this->belongsTo(ItemPostura::class, 'item_postura_id');
    }
    
}
