<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nombre', 'path', 'hash', 'estado'];

    // Relación con el modelo Firma
    public function firmas()
    {
        return $this->hasMany(Firma::class);
    }
}
