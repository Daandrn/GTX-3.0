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
        Schema::create('recupera_senha', function (Blueprint $table) {
            $table->id();
            $table->integer('membro_id')->nullable(false);
            $table->string('nick', 20)->nullable(false);
            $table->string('nova_senha')->nullable(false);
            $table->integer('status_senha')->nullable(false);
            $table->timestamps();

            $table->foreign('status_senha')->references('id')->on('status_senha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recupera_senha');
    }
};
