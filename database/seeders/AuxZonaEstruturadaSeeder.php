<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuxZonaEstruturada;

class AuxZonaEstruturadaSeeder extends Seeder
{
    public function run(): void
    {
        AuxZonaEstruturada::insert([
            [
                'codigo_postal_inicio' => '1000',
                'nome_zona' => 'Lisboa',
                'nome_zona_comercial' => 'Centro',
                'nome_vendedor' => 'Maria Lisboa',
                'email_vendedor' => 'maria@exemplo.com',
                'telemovel_vendedor' => '912345678',
                'order' => 1,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo_postal_inicio' => '4000',
                'nome_zona' => 'Porto',
                'nome_zona_comercial' => 'Norte',
                'nome_vendedor' => 'João Portuense',
                'email_vendedor' => 'joao@exemplo.com',
                'telemovel_vendedor' => '913456789',
                'order' => 2,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo_postal_inicio' => '4900',
                'nome_zona' => 'Viana do Castelo',
                'nome_zona_comercial' => 'Norte',
                'nome_vendedor' => 'Catarina Viana',
                'email_vendedor' => 'catarina@exemplo.com',
                'telemovel_vendedor' => '914567890',
                'order' => 3,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
