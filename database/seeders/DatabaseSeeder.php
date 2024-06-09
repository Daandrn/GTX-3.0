<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\CanalStream;
use App\Models\Membro;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Membro::factory()->create();
        CanalStream::factory()->create();

        // \App\Models\Membro::factory()->create([
        //     'nome' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
