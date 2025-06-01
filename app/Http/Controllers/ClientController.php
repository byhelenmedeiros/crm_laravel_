<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\CrmAddress;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ClientController extends Controller
{
    /**
     * Cria um novo cliente com endereço associado.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $user = auth()->user();

   
    if (!$user->isAdmin()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }
            return Inertia::render('Clients/CreateClient'); // componente Vue que tem o form
    }
    public function store(Request $request)
{
        // Validar os dados de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:crm_clients,email',
            'crm_addresses_id' => 'required|exists:crm_addresses,id',
            'url' => 'nullable|url',
            'team_id' => 'required|exists:teams,id',
            'clientable_type' => 'nullable|string|max:255',
            'clientable_id' => 'nullable|integer',
            'address_type' => 'required|string|max:50',
            'user_created_id' => 'nullable|exists:users,id',
            'user_updated_id' => 'nullable|exists:users,id',
            'user_owner_id' => 'nullable|exists:users,id',
            'user_assigned_id' => 'nullable|exists:users,id',
            'user_deleted_id' => 'nullable|exists:users,id',
            'user_restored_id' => 'nullable|exists:users,id',
        ]);

        // Criar o endereço
        $address = CrmAddress::create([
            'team_id' => $request->team_id,
            'address_type' => $request->address_type,
            'address' => $request->address,
            'name' => $request->name,
            'contact' => $request->contact,
            'phone' => $request->phone,
            'line1' => $request->line1,
            'line2' => $request->line2,
            'line3' => $request->line3,
            'code' => $request->code,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'user_created_id' => $user->id, // Associa o admin que criou
            'user_updated_id' => $user->id, // Associa o admin que atualizou inicialmente
        ]);

        // Criar o cliente e associar o endereço
        $client = Client::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'crm_addresses_id' => $address->id, // Associa o cliente ao endereço
            'user_created_id' => $user->id, // Associa o admin que criou
            'user_updated_id' => $user->id, // Associa o admin que atualizou inicialmente
        ]);

        return response()->json(['client' => $client, 'address' => $address], 201);
    }

    /**
     * Exibe a lista de clientes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all(); 
       return Inertia::render('Clients/Index', [
    'clients' => $clients
]);

    }
}
