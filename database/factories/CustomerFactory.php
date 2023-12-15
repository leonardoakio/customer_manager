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
        return [
            'address_id' => $this->faker->numberBetween(1, 3),
            'name' => $this->faker->name,
            'mother_name' => $this->faker->name,
            'document' => $this->faker->numerify('###########'),
            'cns' => $this->faker->numerify('################'),
            'picture_url' => $this->faker->imageUrl(),
        ];
    }
}
