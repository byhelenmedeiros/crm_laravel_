<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::table('crm_contacts', function (Blueprint $table) {
            // 1. Clube do contrato
            $table->string('contract_club')
                  ->nullable()
                  ->after('external_id');

            // 2. Data de início e fim do contrato
            $table->date('contract_start_date')
                  ->nullable()
                  ->after('contract_club');

            $table->date('contract_end_date')
                  ->nullable()
                  ->after('contract_start_date');

            // 3. Data de renegociação
            $table->date('renegotiation_date')
                  ->nullable()
                  ->after('contract_end_date');

            // 4. Observações do contrato
            $table->text('contract_observations')
                  ->nullable()
                  ->after('renegotiation_date');

            // 5. Pack médio (preço)
            $table->decimal('pack_medio', 10, 2)
                  ->nullable()
                  ->after('contract_observations');

            // 6. Frequência de mudança de pack
            $table->string('pack_change_frequency', 50)
                  ->nullable()
                  ->comment('Frequência com que mudam de pack')
                  ->after('pack_medio');
        });
    }

    public function down()
    {
        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->dropColumn([
                'contract_club',
                'contract_start_date',
                'contract_end_date',
                'renegotiation_date',
                'contract_observations',
                'pack_medio',
                'pack_change_frequency',
            ]);
        });
    }
};
