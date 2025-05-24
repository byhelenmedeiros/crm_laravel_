<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function store(Request $request)
{
    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role'     => 'required|in:admin,user', 
    ]);

    // Verifica se o usuário logado tem permissão para criar o role pretendido
    $this->authorize('create', [$data['role']]);

    // Se for admin, associa automaticamente o crm_team_id do admin que está logado
    if (auth()->user()->hasRole('admin')) {
        $data['crm_team_id'] = auth()->user()->crm_team_id;
    }

    // Criação do usuário...
    $user = User::create([
        'name'    => $data['name'],
        'email'   => $data['email'],
        'password'=> bcrypt($data['password']),
        'crm_team_id' => $data['crm_team_id'] ?? null,
    ]);

    // Atribuição do role
    $user->assignRole($data['role']);

    return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
}

}
