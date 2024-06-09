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
        Schema::create('canal_stream', function (Blueprint $table) {
            $table->id();
            $table->integer('membro_id')->unique();
            $table->integer('plataforma')->nullable();
            $table->string('link_canal', 50)->nullable();
            $table->string('nick_stream', 20)->unique()->Nullable();
            $table->timestamps();

            $table->foreign('membro_id')->references('id')->on('membros')->onDelete('cascade');
            $table->foreign('plataforma')->references('id')->on('plataforma_stream');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canal_stream');
    }
};
