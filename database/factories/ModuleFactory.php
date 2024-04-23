<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom_module' => $this->faker->unique()->word,
            'intitule' => $this->faker->sentence(),
            'masse horaire' => $this->faker->randomNumber(2),
            'formateur_id' => function () {
                return \App\Models\Formateur::factory()->create()->id;
            },
        ];
    }
}
