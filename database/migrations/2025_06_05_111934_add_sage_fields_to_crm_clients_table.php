<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('crm_clients', function (Blueprint $table) {
            $table->unsignedBigInteger('transporte_id')->nullable()->after('url');
            $table->unsignedBigInteger('pagamento_id')->nullable()->after('transporte_id');
            $table->unsignedBigInteger('modalidade_pagamento_id')->nullable()->after('pagamento_id');
            $table->unsignedBigInteger('preco_id')->nullable()->after('modalidade_pagamento_id');
            $table->decimal('desconto_linha', 8, 2)->default(0)->after('preco_id');
            $table->decimal('desconto_global', 8, 2)->default(0)->after('desconto_linha');
            $table->string('telefone1', 20)->nullable()->after('desconto_global');
            $table->string('telefone2', 20)->nullable()->after('telefone1');
            $table->string('telefone3', 20)->nullable()->after('telefone2');
            $table->string('telefone4', 20)->nullable()->after('telefone3');
            $table->string('movel1', 20)->nullable()->after('telefone4');
            $table->string('movel2', 20)->nullable()->after('movel1');
        });
    }

    public function down(): void
    {
        Schema::table('crm_clients', function (Blueprint $table) {
            $table->dropColumn([
                'transporte_id',
                'pagamento_id',
                'modalidade_pagamento_id',
                'preco_id',
                'desconto_linha',
                'desconto_global',
                'telefone1',
                'telefone2',
                'telefone3',
                'telefone4',
                'movel1',
                'movel2',
            ]);
        });
    }
};
