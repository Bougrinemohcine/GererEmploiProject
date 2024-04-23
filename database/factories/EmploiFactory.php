<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\emploi>
 */
class EmploiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateDebu = fake()->dateTimeThisMonth('next Monday')->format('Y-m-d');
        $dateFin = date('Y-m-d', strtotime($dateDebu . ' + 6 days'));
        $nomEmploi = $this->faker->name;
        return [
            "nom_emploi"=>$nomEmploi,
            "date_debu"=>$dateDebu,
            "date_fin"=>$dateFin
        ];
    }
}
