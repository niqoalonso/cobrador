<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadFinanciera extends Model
{
    use HasFactory;

    protected $primaryKey = "id_entidad";

    protected $fillable = ['nombre'];
}
