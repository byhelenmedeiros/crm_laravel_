<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AuxZonaComercial extends Model
{
    protected $table = 'aux_zona_comerciais';

    protected $fillable = [
        'nome',
        'zona_id',
        'active',
    ];

    public function zona(): BelongsTo
    {
        return $this->belongsTo(AuxZona::class, 'zona_id');
    }

    public function vendedor(): HasOne
    {
        return $this->hasOne(AuxVendor::class, 'zona_comercial_id');
    }
}
