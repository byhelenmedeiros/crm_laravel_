<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('crm_clients', function (Blueprint $table) {
            $table->unsignedBigInteger('group_subdivision_id')->nullable()->after('client_group_id');

            $table->foreign('group_subdivision_id')
                ->references('id')
                ->on('group_subdivisions')
                ->onDelete('set null'); // ou 'cascade' ou 'restrict' conforme tua regra de negócio
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crm_clients', function (Blueprint $table) {
            $table->dropForeign(['group_subdivision_id']);
            $table->dropColumn('group_subdivision_id');
        });
    }
};
