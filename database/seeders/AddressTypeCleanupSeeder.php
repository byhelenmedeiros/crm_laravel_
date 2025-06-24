<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CrmAddressType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;

class AddressTypeCleanupSeeder extends Seeder
{
    /**
     * Execute o seeder para remover todos os tipos de endereço
     * exceto: Fiscal, Correspondência e Entrega.
     */
    public function run()
    {
        // Defina os nomes que devem permanecer
        $keep = [
            'Fiscal',
            'Correspondência',
            'Entrega',
        ];

        // Dentro de uma transação para garantir atomicidade
        DB::transaction(function () use ($keep) {
            // Se quiser garantir que colunas de chave estrangeira não bloqueiem a exclusão,
            // descomente as próximas linhas (caso sua tabela esteja com foreign keys ativas):
            //
            // Schema::disableForeignKeyConstraints();
            //
            // Realiza a exclusão de todas as linhas cujo name NÃO esteja em $keep
            CrmAddressType::whereNotIn('name', $keep)->delete();
            //
            // Schema::enableForeignKeyConstraints();
        });
    }
}
