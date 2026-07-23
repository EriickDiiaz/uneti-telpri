<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\HasActivity;
use Spatie\Activitylog\Support\LogOptions;

class Linea extends Model
{
    use HasActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
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
            ])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Se creó la línea.',
                'updated' => 'Se actualizó la línea.',
                'deleted' => 'Se eliminó la línea.',
                default => "Se {$eventName} la línea.",
            });
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
