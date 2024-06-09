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
        Schema::create('status_senha', function (Blueprint $table) {
            $table->id();
            $table->string('descricao', 50)->notNullable();
            $table->timestamps();
        });

        $values = [
            [ 'id' => 0, 'descricao' => 'Aprovado'],
            [ 'id' => 1, 'descricao' => 'Solicitado'],
            [ 'id' => 2, 'descricao' => 'Reprovado'],
        ];
        
        DB::table('status_senha')->insert($values);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_senha');
    }
};
