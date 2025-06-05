<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientGroup;
use App\Models\CrmAddress;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Models\CrmAddressType;
use App\Models\Vendor;  


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
      $zones = Zone::orderBy('external_id')->get(['id', 'external_id', 'name']);
        $vendors = Vendor::orderBy('external_id')->get(['id', 'external_id', 'name']);
        // Log para confirmar no storage/logs/laravel.log
        Log::info('ClientController@create carregando tipos de endereço:', $addressTypes->toArray());

        Log::info('Tipos de endereço carregados:', $addressTypes->toArray());        
        // Retorna a view via Inertia
           return Inertia::render('Clients/Create', [
        'addressTypes' => $addressTypes,
        'clientGroups' => $clientGroups,
          'zones'   => $zones,
            'vendors' => $vendors,
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

        // 1) Validação dos dados básicos do cliente
        $validatedClient = $request->validate([
            'name'                  => 'required|string|max:255',
            'nif'                   => 'nullable|string|max:9',
            'url'                   => 'nullable|url',
            'clientable_type'       => 'nullable|string|max:255',
            'clientable_id'         => 'nullable|integer',
            'client_group_id'       => 'nullable|exists:client_groups,id',
            'group_subdivision_id'  => 'nullable|exists:group_subdivisions,id',
             'zone_id'   => 'nullable|exists:zones,id',
            'vendor_id' => 'nullable|exists:vendors,id',
        ]);

        // 2) Validação do array de endereços (pelo menos um)
        $validatedAddresses = $request->validate([
            'addresses'                           => 'required|array|min:1',
            'addresses.*.address_type_id'         => 'required|exists:crm_address_types,id',
            'addresses.*.address'                 => 'required|string|max:255',
            'addresses.*.name'                    => 'nullable|string|max:255',
            'addresses.*.contact'                 => 'nullable|string|max:255',
            'addresses.*.phone'                   => 'nullable|string|max:20',
            'addresses.*.line1'                   => 'nullable|string|max:255',
            'addresses.*.line2'                   => 'nullable|string|max:255',
            'addresses.*.line3'                   => 'nullable|string|max:255',
            'addresses.*.code'                    => 'nullable|string|max:50',
            'addresses.*.city'                    => 'nullable|string|max:100',
            'addresses.*.state'                   => 'nullable|string|max:100',
            'addresses.*.country'                 => 'nullable|string|max:100',
            'addresses.*.primary'                 => 'sometimes|in:0,1',
        ]);

        // 3) Cria o cliente primeiro
        $client = Client::create([
            'name'                  => $validatedClient['name'],
            'nif'                   => $validatedClient['nif'] ?? null,
            'url'                   => $validatedClient['url'] ?? null,
            'clientable_type'       => $validatedClient['clientable_type'] ?? null,
            'clientable_id'         => $validatedClient['clientable_id'] ?? null,
            'client_group_id'       => $validatedClient['client_group_id'] ?? null,
            'group_subdivision_id'  => $validatedClient['group_subdivision_id'] ?? null,
            'user_created_id'       => $user->id,
            'user_updated_id'       => $user->id,
        ]);

        // 4) Cria cada endereço associado ao cliente
        foreach ($validatedAddresses['addresses'] as $addrData) {
            $client->addresses()->create([
                'address_type_id'  => $addrData['address_type_id'],
                'address'          => $addrData['address'],
                'name'             => $addrData['name']    ?? null,
                'contact'          => $addrData['contact'] ?? null,
                'phone'            => $addrData['phone']   ?? null,
                'line1'            => $addrData['line1']   ?? null,
                'line2'            => $addrData['line2']   ?? null,
                'line3'            => $addrData['line3']   ?? null,
                'code'             => $addrData['code']    ?? null,
                'city'             => $addrData['city']    ?? null,
                'state'            => $addrData['state']   ?? null,
                'country'          => $addrData['country'] ?? null,
                'primary'          => $addrData['primary'] ?? 0,
                'addressable_type' => Client::class,
                'addressable_id'   => $client->id,
                'user_created_id'  => $user->id,
                'user_updated_id'  => $user->id,
            ]);
        }

        DB::commit();

        Log::info('Cliente criado com sucesso:', ['client_id' => $client->id]);

        return response()->json([
            'message' => 'Cliente e endereços criados com sucesso!',
            'client'  => $client->load('addresses'),
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

    /**
     * Exibe todos os clientes (index).
     * Faz log do número de registros e dos IDs encontrados.
     */
    public function index(Request $request)
    {
        // Se você tiver policy, pode manter esta linha; senão, comente ou remova:
        $this->authorize('viewAny', Client::class);

        // Busca todos os clientes, carregando endereços e tipo de endereço
        $clients = Client::with('addresses.addressType')
                    ->orderBy('name')
                    ->get();

        // Log para confirmar no storage/logs/laravel.log
        Log::debug('DEBUG - ClientController@index: total de clientes = '.$clients->count(), [
            'ids' => $clients->pluck('id')->toArray(),
        ]);

        return Inertia::render('Clients/Index', [
            'clients' => $clients,
        ]);
    }

    /**
     * Exibe os detalhes de um cliente específico pelo ID.
     * Faz log do ID solicitado.
     */
public function show($id)
    {
        // Carrega o cliente, junto com endereços (e tipo) + grupo + subdivisão
        $client = Client::with([
            'addresses.addressType',
            'clientGroup',
            'groupSubdivision',
        ])->findOrFail($id);

        Log::debug("DEBUG - ClientController@show: buscando cliente ID = {$id}", [
            'cliente_encontrado' => $client->only(['id','name','email']),
        ]);

        return Inertia::render('Clients/Show', [
            'client' => $client,
        ]);
    }


    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        Log::debug("DEBUG - ClientController@destroy: removendo cliente de ID = {$id}", [
            'cliente_encontrado' => $client->only(['id', 'name', 'email']),
        ]);
        // Remove o cliente
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente excluído com sucesso!');
    }

    /**
     * Exibe a tela de edição de cliente.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Busca o cliente pelo ID ou lança 404 se não existir
        $client = Client::with('addresses.addressType')->findOrFail($id);
         $zones = Zone::orderBy('external_id')->get(['id', 'external_id', 'name']);
        $vendors = Vendor::orderBy('external_id')->get(['id', 'external_id', 'name']);

        // Log para confirmar no storage/logs/laravel.log
        Log::debug("DEBUG - ClientController@edit: editando cliente de ID = {$id}", [
            'cliente_encontrado' => $client->only(['id', 'name', 'email']),
        ]);

        // Retorna a view via Inertia
        return Inertia::render('Clients/Edit', [
            'client'  => $client->load(['zone', 'vendor']),
            'zones'   => $zones,
            'vendors' => $vendors,
        ]);

    }
    //exibir  detalhes do cliente
  public function details($id)
{
    $client = Client::with('addresses.addressType')->findOrFail($id);

    Log::debug("DEBUG - ClientController@details: detalhes do cliente de ID = {$id}", [
        'cliente_encontrado' => $client->only(['id', 'name', 'email']),
    ]);

    return Inertia::render('Clients/Details', [
        'client' => $client,
    ]);
}

}
