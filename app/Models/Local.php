<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;

    protected $primaryKey = "id_local";

    protected $fillable = ['identificador', 'direccion', 'area_id', 'estado_id'];

    public function Area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function Estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function Arriendo()
    {
        return $this->belongsToMany(Arriendo::class);
    }
}
