<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDadosComplementaresToCrmClientsTable extends Migration
{
    public function up()
    {
        Schema::table('crm_clients', function (Blueprint $table) {
            // 1. Nome do responsável
            $table->string('responsavel_nome')->nullable()->after('name');

            // 2. Flags de envio de e‐mails
            $table->enum('recebe_email_orcamentos', ['s', 'n'])
                  ->default('n')
                  ->after('responsavel_nome');
            $table->enum('recebe_email_encomendas', ['s', 'n'])
                  ->default('n')
                  ->after('recebe_email_orcamentos');
            $table->enum('recebe_email_faturas', ['s', 'n'])
                  ->default('n')
                  ->after('recebe_email_encomendas');
            $table->enum('recebe_email_campanhas', ['s', 'n'])
                  ->default('n')
                  ->after('recebe_email_faturas');

            // 3. Data de aniversário
            $table->date('data_aniversario')->nullable()->after('recebe_email_campanhas');

            // 5. Cores do clube (3 colunas)
            $table->string('cor_clube_1')->nullable()->after('data_aniversario');
            $table->string('cor_clube_2')->nullable()->after('cor_clube_1');
            $table->string('cor_clube_3')->nullable()->after('cor_clube_2');

            // 6. Padrão do clube
            $table->string('padrao_clube')->nullable()->after('cor_clube_3');

            // 7. Número total de atletas
            $table->unsignedInteger('numero_total_atletas')->default(0)->after('padrao_clube');

            // 8. Cliente desde
            $table->date('cliente_desde')->nullable()->after('numero_total_atletas');

            // 9. Limite de crédito
            $table->decimal('limite_credito', 15, 2)
                  ->default(0)
                  ->after('cliente_desde');

            // 10. Notas gerais
            $table->text('notas_gerais')->nullable()->after('limite_credito');
        });
    }

    public function down()
    {
        Schema::table('crm_clients', function (Blueprint $table) {
            $table->dropColumn([
                'responsavel_nome',
                'recebe_email_orcamentos',
                'recebe_email_encomendas',
                'recebe_email_faturas',
                'recebe_email_campanhas',
                'data_aniversario',
                'cor_clube_1',
                'cor_clube_2',
                'cor_clube_3',
                'padrao_clube',
                'numero_total_atletas',
                'cliente_desde',
                'limite_credito',
                'notas_gerais',
            ]);
        });
    }
}
