<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'type' => $this->faker->randomElement(['selling', 'renting']),
            'property_type' => $this->faker->randomElement(['house', 'apartment', 'urban land', 'rural land']),
            'city' => $this->faker->city(),
            'neighborhood' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'area' => $this->faker->numberBetween(50, 300),
            'bedrooms' => $this->faker->numberBetween(1, 6),
            'bathrooms' => $this->faker->numberBetween(1, 4),
            'car_spots' => $this->faker->numberBetween(1, 4),
            'price' => $this->faker->randomFloat(2, 100000, 1000000),
            'rent' => $this->faker->randomFloat(2, 500, 3000),
            'condo_price' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}
