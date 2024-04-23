<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\seance>
 */
class SeanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day' => $this->faker->randomElement(['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi']),
            'partie_jour' => $this->faker->randomElement(['Matin', 'A.Midi']),
            'order_seance' => $this->faker->randomElement(['s1', 's2', 's3', 's4']),
            'date_debut' => $this->faker->date(),
            'date_fin' => $this->faker->date(),
            'id_salle' => function () {
                return \App\Models\Salle::factory()->create()->id;
            },
            'id_formateur' => function () {
                return \App\Models\Formateur::factory()->create()->id;
            },
            'id_groupe' => function () {
                return \App\Models\Groupe::factory()->create()->id;
            },
            'id_emploi' => function () {
                return \App\Models\Emploi::factory()->create()->id;
            },
            'type_seance' => $this->faker->randomElement(['presentielle', 'team', 'efm']),
        ];
    }
}
