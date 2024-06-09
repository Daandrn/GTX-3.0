<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Membro::factory(1)->create();
        \App\Models\CanalStream::factory(1)->create();

        // \App\Models\Membro::factory()->create([
        //     'nome' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
