<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Cria o usuário com a role 'SuperAdmin'
        $superAdminRole = Role::where('name', 'SuperAdmin')->first();

        User::create([
            'name' => 'Admin UIN Sports',
            'email' => 'admin@uin-sports.pt',
            'password' => bcrypt('superadmin123'),  // Defina a senha conforme desejado
        ])->assignRole($superAdminRole);  // Atribui a role 'SuperAdmin' ao usuário
    }
}
