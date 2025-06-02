<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientGroup;
use App\Models\CrmAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Models\CrmAddressType;


class ClientController extends Controller
{
    /**
     * Exibe a tela de criação de cliente.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Log::info("ClientController@create chamada pelo user id: " . auth()->id());

        $this->authorize('create', Client::class);
        $addressTypes = CrmAddressType::all(['id', 'name']);
    $clientGroups = ClientGroup::orderBy('id')->get();

        Log::info('Tipos de endereço carregados:', $addressTypes->toArray());        
        // Retorna a view via Inertia
           return Inertia::render('Clients/Create', [
        'addressTypes' => $addressTypes,
        'clientGroups' => $clientGroups,
    ]);
    }

    /**
     * Armazena um novo cliente com endereço associado.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
 public function store(Request $request)
{
    try {
        DB::beginTransaction();

        Log::info('ClientController@store chamado com dados:', $request->all());

        $user = auth()->user();

        // Validação dos dados
        $validated = $request->validate([
            'name' => 'required|string|max:255',
                'nif' => 'nullable|string|max:9',
            'url' => 'nullable|url',
            'clientable_type' => 'nullable|string|max:255',
            'clientable_id' => 'nullable|integer',
            'address_type_id' => 'required|exists:crm_address_types,id', // ID do tipo
            'address' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'line1' => 'nullable|string|max:255',
            'line2' => 'nullable|string|max:255',
            'line3' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
    'client_group_id' => 'nullable|exists:client_groups,id',
        ]);

        // 1. Cria o cliente primeiro
        $client = Client::create([
            'name' => $validated['name'],
                'nif' => $validated['nif'] ?? null,
            'url' => $validated['url'] ?? null,
            'clientable_type' => $validated['clientable_type'] ?? null,
            'clientable_id' => $validated['clientable_id'] ?? null,
            'user_created_id' => $user->id,
            'user_updated_id' => $user->id,
    'client_group_id' => $validated['client_group_id'] ?? null,

        ]);

        // 2. Cria o endereço associado ao cliente
        $address = CrmAddress::create([
            'address_type_id' => $validated['address_type_id'],
            'address' => $validated['address'],
            'name' => $validated['name'],  // geralmente o nome do cliente ou da empresa
            'contact' => $validated['contact'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'line1' => $validated['line1'] ?? null,
            'line2' => $validated['line2'] ?? null,
            'line3' => $validated['line3'] ?? null,
            'code' => $validated['code'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'country' => $validated['country'] ?? null,
            'addressable_type' => Client::class,      // Indica que esse endereço pertence a um cliente
            'addressable_id' => $client->id,           // ID do cliente criado
            'user_created_id' => $user->id,
            'user_updated_id' => $user->id,
        ]);

        // 3. Atualiza o cliente com o endereço criado, se desejar (opcional)
        $client->crm_addresses_id = $address->id;
        $client->save();

        DB::commit();

        Log::info('Cliente criado com sucesso:', ['client_id' => $client->id]);

        return response()->json([
            'message' => 'Cliente criado com sucesso!',
            'client' => $client,
            'address' => $address,
        ], 201);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Erro ao criar cliente: ' . $e->getMessage());
        return response()->json(['error' => 'Erro ao criar cliente'], 500);
    }
}
    /**
     * Exibe a lista paginada de clientes.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Client::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', "%{$request->name}%");
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', "%{$request->phone}%");
        }
        if ($request->filled('address')) {
            $query->where('address', 'like', "%{$request->address}%");
        }

        $clients = $query->paginate(10)->withQueryString();

        return Inertia::render('Clients/Index', [
            'clients' => $clients,
            'filters' => $request->only(['name', 'email', 'phone', 'address']),
        ]);
    }
}
