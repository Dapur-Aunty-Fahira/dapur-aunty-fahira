<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerAddress>
 */
class CustomerAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'recipient_name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'country' => 'Indonesia',
            'postal_code' => $this->faker->postcode(),
            'coordinates' => $this->faker->optional()->latitude() . ',' . $this->faker->optional()->longitude(),
            'notes' => $this->faker->optional()->sentence(),
            'is_default' => $this->faker->boolean(30),
            'is_active' => true,
        ];
    }
}
