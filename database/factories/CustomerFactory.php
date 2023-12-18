<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('pt_BR');
        static $addressId = 1;

        return [
            'address_id' => $addressId++,
            'name' => $faker->name,
            'mother_name' => $faker->name('female'),
            'document' => $faker->numerify('###########'), 
            'cns' => $faker->numerify('################'),
            'picture_url' => 'picture' . $faker->numberBetween(1, 10000) . '.jpg',
        ];
    }
}
