<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->locale('pt_BR');
     
        return [
            'postal_code' => $this->faker->postcode,
            'address' => $this->faker->streetAddress,
            'number' => $this->faker->numberBetween(1, 100),
            'complement' => $this->faker->word,
            'neighborhood' => $this->faker->word,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr
        ];
    }
}
