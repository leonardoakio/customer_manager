<?php

namespace Database\Factories;

use App\Infrastructure\Helpers\PostalCodeRegex;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    use PostalCodeRegex;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('pt_BR');

        return [
            'postal_code' => $this->extractNumericPostalCode($faker->postcode),
            'address' => $faker->streetName,
            'number' => $faker->buildingNumber,
            'complement' => $faker->randomElement(["Apartamento $faker->numerify"]),
            'neighborhood' => $faker->randomElement(['Nova suissa', 'Prado', 'Vila Oeste', 'Buritis', 'Gutierrez', 'Alphaville', 'Serra']),
            'city' => $faker->city,
            'state' => $faker->state(),
        ];
    }
}
