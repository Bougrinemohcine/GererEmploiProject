<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\groupe>
 */
class GroupeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom_groupe' => $this->faker->unique()->word(),
            'Mode_de_formation' => $this->faker->randomElement(['Formation initiale', 'Formation continue']),
            'Niveau' => $this->faker->randomElement(['Premier cycle', 'Deuxième cycle', 'Troisième cycle']),
            'filiere_id' => function () {
                return \App\Models\Filiere::factory()->create()->id;
            },
        ];
    }
}
