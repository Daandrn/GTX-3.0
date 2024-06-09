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
        Schema::create('membros', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 30)->nullable(false);
            $table->string('nick', 20)->unique()->nullable(false);
            $table->integer('plataforma')->nullable(false);
            $table->integer('status_solicit')->nullable(false);
            $table->string('email')->unique()->nullable(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('senha')->nullable(false);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('status_solicit')->references('id')->on('status_membros');
            $table->foreign('plataforma')->references('id')->on('plataforma_game');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membros');
    }
};
