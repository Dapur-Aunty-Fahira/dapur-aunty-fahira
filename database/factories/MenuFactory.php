<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'name' => $this->faker->unique()->words(3, true),
            'image' => $this->faker->optional()->imageUrl(640, 480, 'food'),
            'description' => $this->faker->optional()->paragraph(),
            'price' => $this->faker->randomFloat(2, 5000, 50000),
            'min_order' => $this->faker->numberBetween(1, 5),
            'is_available' => $this->faker->boolean(95),
            'is_popular' => $this->faker->boolean(30),
            'is_new' => $this->faker->boolean(20),
        ];
    }
}
