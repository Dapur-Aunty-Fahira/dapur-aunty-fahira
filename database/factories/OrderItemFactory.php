<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $menu = Menu::inRandomOrder()->first();

        $quantity = $this->faker->numberBetween(1, 3);
        $price = $menu?->price ?? $this->faker->randomFloat(2, 10000, 50000);
        return [
            'menu_id' => $menu?->id ?? Menu::factory(),
            'quantity' => $quantity,
            'price' => $price,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
