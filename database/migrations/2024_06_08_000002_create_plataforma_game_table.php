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
        Schema::create('plataforma_game', function (Blueprint $table) {
            $table->id();
            $table->string('descricao', 50)->nullable(false);
            $table->timestamps();
        });

        $values = [
            [ 'id' => 1, 'descricao' => 'PC'],
            [ 'id' => 2, 'descricao' => 'Xbox Séries'],
            [ 'id' => 3, 'descricao' => 'Ps5'],
        ];

        DB::table('plataforma_game')->insert($values);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plataforma_game');
    }
};
