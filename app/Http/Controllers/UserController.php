<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Exibe a listagem de usuários.
     *
     * @return Response
     */
    public function index(): Response
    {
        $users = User::all();
        return Inertia::render('Users/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Exibe os detalhes de um usuário específico.
     *
     * @param  User  $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return Inertia::render('Users/Show', [
            'user' => $user,
        ]);
    }

    /**
     * Exibe o formulário para criar um novo usuário (normal).
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Users/CreateBasicUser');
    }

    /**
     * Armazena um novo usuário (normal).
     *
     * Valida os dados informados, associa o crm_team_id se o usuário logado for admin,
     * e atribui o role conforme informado.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:admin,user',
        ]);

        // Verifica a autorização via policy (ou implementação customizada)
        $this->authorize('create', [$data['role']]);

        // Se o usuário logado tiver role "admin", associa automaticamente o crm_team_id
        if (auth()->user()->hasRole('admin')) {
            $data['crm_team_id'] = auth()->user()->crm_team_id;
        }

        $user = User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'crm_team_id' => $data['crm_team_id'] ?? null,
        ]);

        $user->assignRole($data['role']);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Exibe o formulário para editar um usuário.
     *
     * @param  User  $user
     * @return Response
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Users/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Atualiza os dados de um usuário.
     *
     * @param  Request  $request
     * @param  User     $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role'     => 'required|in:admin,user',
        ]);

        $this->authorize('update', $user);

        $user->name  = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        $user->syncRoles([$data['role']]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove um usuário.
     *
     * @param  User  $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }

    /**
     * Exibe o formulário para criar um Administrador do Setor (Team Admin).
     *
     * Esse método será chamado apenas por usuários com role "superadmin".
     *
     * @return Response
     */
    public function createTeamAdmin(): Response
    {
        return Inertia::render('Users/CreateTeamAdmin');
    }

    /**
     * Armazena um novo Administrador do Setor (Team Admin).
     *
     * Valida os dados, associa o novo Team Admin ao crm_team_id do superadmin autenticado
     * e atribui automaticamente o role "team_admin".
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function storeTeamAdmin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $crmTeamId = auth()->user()->crm_team_id ?? null;

        $user = User::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'crm_team_id' => $crmTeamId,
        ]);

        $user->assignRole('team_admin');

        return redirect()
            ->route('users.index')
            ->with('success', 'Administrador do Setor criado com sucesso!');
    }
}
