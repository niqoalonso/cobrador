<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPostura extends Model
{
    use HasFactory;

    protected $primaryKey = "id_item_postura";

    protected $fillable = ['nombre', 'valor'];
}
