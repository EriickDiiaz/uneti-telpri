<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
    protected $table = 'lineas';

    protected $casts = [
        'acceso' => 'array',
    ];

    protected $fillable = [
        'linea',
        'plataforma',
        'estado',
        'titular',
        'inventario',
        'serial',
        'mac',
        'ubicacion_id',
        'par',
        'localidad_id',
        'piso_id',
        'acceso',
        'observacion',
    ];

    public function plataforma()
    {
        return $this->belongsTo(Plataforma::class, 'plataforma', 'nombre');
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }
    
    public function piso()
    {
        return $this->belongsTo(Piso::class);
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }
}
