<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientGroupClient extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'group_subdivision_id'];
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function subdivision()
    {
        return $this->belongsTo(GroupSubdivision::class, 'group_subdivision_id');
    }
}
