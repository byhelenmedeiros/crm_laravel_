<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuxVendor extends Model
{
    protected $table = 'aux_vendors';

    protected $fillable = [
        'nome',
        'email',
        'telemovel',
        'zona_comercial_id',
        'active',
    ];

    public function zonaComercial(): BelongsTo
    {
        return $this->belongsTo(AuxZonaComercial::class, 'zona_comercial_id');
    }
}
