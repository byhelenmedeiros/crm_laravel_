<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'crm_clients';

    protected $fillable = [
        'id',

        'external_id',
        // 'team_id',
        'clientable_type',
        'clientable_id',
        'name',
        'nif',
        'client_group_id',
        'address_type_id',  
        'address', 
        'crm_addresses_id',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
        'user_restored_id',
        'user_owner_id',
        'user_assigned_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'url',
    ];

    /**
     * Relacionamento com a tabela crm_addresses
     * Um cliente tem um endereço (1:1)
     */
    public function address()
    {
        return $this->belongsTo(CrmAddress::class, 'crm_addresses_id'); // Define a chave estrangeira
    }

    /**
     * Relacionamento com o usuário que criou o cliente (User)
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_created_id');
    }

    /**
     * Relacionamento com o usuário que atualizou o cliente (User)
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'user_updated_id');
    }

    /**
     * Relacionamento com o usuário que deletou o cliente (User)
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'user_deleted_id');
    }

    /**
     * Relacionamento com o usuário que restaurou o cliente (User)
     */
    public function restoredBy()
    {
        return $this->belongsTo(User::class, 'user_restored_id');
    }
    public function addresses()
    {
        return $this->morphMany(CrmAddress::class, 'addressable');
    }

    /**
     * Relacionamento com o usuário proprietário do cliente (User)
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_owner_id');
    }

    /**
     * Relacionamento com o usuário atribuído ao cliente (User)
     */
    public function assigned()
    {
        return $this->belongsTo(User::class, 'user_assigned_id');
    }
}
