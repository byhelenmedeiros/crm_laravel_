<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'crm_clients';
protected $fillable = [
   // 'external_id',           // número do cliente
    'clientable_type',
    'clientable_id',
    'name',
    'nif',
    'client_group_id',
    'group_subdivision_id',
    'address_type_id',
    'address',
    'crm_addresses_id',
    'user_created_id',
    'user_updated_id',
    'user_deleted_id',
    'user_restored_id',
    'user_owner_id',
    'user_assigned_id',
    'url',
    'localidade',            
    'zone_id',
    'vendor_id',
    'transporte_id',         
    'pagamento_id',          
    'preco_id',              
    'desconto_linha',        
    'desconto_global',       
    'telefone1',             
    'telefone2',             
    'telefone3',             
    'telefone4',             
    'movel1',                
    'movel2',                
];

    /**
     * Relacionamento com a tabela crm_addresses
     * Um cliente tem um endereço (1:1)
     */
    public function address()
    {
            return $this->morphMany(CrmAddress::class, 'addressable');
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

    public function clientGroup()
    {
        return $this->belongsTo(ClientGroup::class, 'client_group_id');
    }

    public function groupSubdivision()
    {
        return $this->belongsTo(GroupSubdivision::class, 'group_subdivision_id');
    }

public function primaryAddress()
{
    return $this->addresses()->where('primary', 1)->first();
}
   public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
     public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

}

