<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table = 'localidades';
    
    protected $fillable = ['nombre'];

    public function pisos()
    {
        return $this->hasMany(Piso::class);
    }

    public function lineas()
    {
        return $this->hasMany(Linea::class);
    }
}
