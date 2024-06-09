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
        Schema::create('status_membros', function (Blueprint $table) {
            $table->id();
            $table->string('descricao', 50)->nullable(false);
            $table->timestamps();
        });

        $values = [
            [ 'id' => 0, 'descricao' => 'Pendente'],
            [ 'id' => 1, 'descricao' => 'Membro'],
            [ 'id' => 2, 'descricao' => 'Rejeitado'],
            [ 'id' => 3, 'descricao' => 'Expulso'],
            [ 'id' => 4, 'descricao' => 'Administrador'],
        ];

        DB::table('status_membros')->insert($values);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_membros');
    }
};
