<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Models\Team;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Exibe a listagem de usuários, excluindo os superadmins.
     */
    public function index(): Response
    {
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superadmin');
        })->get();

        return Inertia::render('Users/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Exibe os detalhes de um usuário específico.
     */
    public function show(User $user): Response
    {
        return Inertia::render('Users/Show', [
            'user' => $user,
        ]);
    }

    /**
     * Exibe o formulário para criar um novo usuário.
     */
    public function create(): Response
    {
        return Inertia::render('Users/CreateBasicUser');
    }

    /**
     * Armazena um novo usuário no banco de dados.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        $data['crm_team_id'] = auth()->user()->current_crm_team_id ?? auth()->user()->crm_team_id;
        $data['role_id'] = 3;

        try {
            $user = User::create([
                'name'               => $data['name'],
                'email'              => $data['email'],
                'password'           => Hash::make($data['password']),
                'crm_team_id'        => $data['crm_team_id'],
                'current_crm_team_id'=> $data['crm_team_id'],
                'role_id'            => $data['role_id'],
            ]);

            $user->assignRole('user');

            return response()->json(['success' => 'Usuário criado com sucesso!', 'user' => $user]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar usuário', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Exibe o formulário para editar um usuário.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Users/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Atualiza os dados de um usuário.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id'  => 'required|in:admin,user',
        ]);

        $this->authorize('update', $user);

        $user->name  = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        $user->syncRoles([$data['role_id']]);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove um usuário.
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }

    /**
     * Exibe o formulário para criar um Administrador do Setor (Team Admin).
     */
    public function createTeamAdmin(): Response
    {
        $teams = Team::all(['id', 'name']); 
        return Inertia::render('Teams/CreateTeamAdmin', [
            'teams' => $teams,
        ]);
    }

    /**
     * Armazena um novo Administrador do Setor (Team Admin).
     */
    public function storeTeamAdmin(Request $request)
    {
        Log::info('storeTeamAdmin chamado', ['request' => $request->all()]);

        try {
            $validated = $request->validate([
                'name'        => ['required', 'string', 'max:255'],
                'email'       => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password'    => ['required', 'string', 'min:8', 'confirmed'],
                'crm_team_id' => ['required', 'exists:crm_teams,id'],
            ]);

            Log::info('Dados validados:', $validated);

            $roleAdminId = 2;

            $user = User::create([
                'name'               => $validated['name'],
                'email'              => $validated['email'],
                'password'           => Hash::make($validated['password']),
                'current_crm_team_id'=> $validated['crm_team_id'],
                'role_id'            => $roleAdminId,
            ]);

            Log::info('Administrador do time criado:', ['user_id' => $user->id]);

            return response()->json(['success' => true, 'message' => 'Administrador criado com sucesso!']);
        } catch (\Exception $e) {
            Log::error('Erro ao criar administrador do time: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erro interno no servidor.'], 500);
        }
    }
}
