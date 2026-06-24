<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plataforma extends Model
{
    protected $fillable =[
        'nombre',
    ];

    public function lineas()
    {
        return $this->hasMany(Linea::class);
    }
}
