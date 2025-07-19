<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\CustomerAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_number' => strtoupper('ORD-' . Str::random(8)),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'courier_id' => null, // bisa diisi manual jika ingin
            'address' => $this->faker->address,
            'delivery_date' => $this->faker->optional()->date(),
            'delivery_time' => $this->faker->optional()->time(),
            'notes' => $this->faker->optional()->sentence(),
            'total_price' => 0, // akan dihitung ulang setelah buat order_items
            'payment_method' => 'transfer',
            'payment_proof' => null,
            'payment_status' => 'Validasi pembayaran',
            'order_status' => 'menunggu konfirmasi',
            'order_at' => now(),
            'processed_at' => null,
            'sent_at' => null,
            'arrived_at' => null,
            'arrival_proof' => null,
            'completed_at' => null,
            'canceled_at' => null,
            'cancellation_reason' => null,
            'canceled_by' => null,
        ];
    }
}
