<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $primaryKey = "id_area";

    protected $fillable = ["nombre", "estado_id"];

    public function Local()
    {
        return $this->hasMany(Local::class, 'area_id', 'id_area');
    }
}
