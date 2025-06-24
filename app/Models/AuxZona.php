<?php

 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuxZona extends Model
{
    protected $table = 'aux_zonas';

    protected $fillable = [
        'nome',
        'codigo_postal_inicio',
        'order',
        'active',
    ];

    public function zonaComerciais(): HasMany
    {
        return $this->hasMany(AuxZonaComercial::class, 'zona_id');
    }
}
