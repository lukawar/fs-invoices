<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->unique()->bothify('FV####/##'),
            'seller_nip' => $this->faker->numerify('##########'),
            'buyer_nip' => $this->faker->numerify('##########'),
            'product_name' => $this->faker->word(),
            'product_price' => $this->faker->randomFloat(2, 10, 1000),
            'amount' => $this->faker->numberBetween(1, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
