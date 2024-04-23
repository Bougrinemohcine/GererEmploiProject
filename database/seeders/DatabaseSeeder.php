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
        // \App\Models\User::factory(10)->create();
        // \App\Models\formateur::factory(10)->create();
        // \App\Models\emploi::factory(2)->create();
        // \App\Models\salle::factory(10)->create();
        // \App\Models\filiere::factory(10)->create();
        // \App\Models\groupe::factory(10)->create();
        // \App\Models\module::factory(10)->create();
        \App\Models\seance::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
