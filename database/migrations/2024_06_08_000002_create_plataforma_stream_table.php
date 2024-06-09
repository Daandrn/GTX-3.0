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
        Schema::create('plataforma_stream', function (Blueprint $table) {
            $table->id();
            $table->string('descricao', 50)->nullable(false);
            $table->timestamps();
        });

        $values = [
            [ 'id' => 1, 'descricao' => 'Youtube'],
            [ 'id' => 2, 'descricao' => 'Twitch'],
            [ 'id' => 3, 'descricao' => 'TikTok'],
            [ 'id' => 4, 'descricao' => 'Facebook'],
            [ 'id' => 5, 'descricao' => 'Kwai'],
        ];

        DB::table('plataforma_stream')->insert($values);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plataforma_stream');
    }
};
