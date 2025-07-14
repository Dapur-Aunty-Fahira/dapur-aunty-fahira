<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()
            ->count(5)
            ->create()
            ->each(function ($order) {
                $menus = Menu::inRandomOrder()->take(rand(1, 3))->get();
                $total = 0;

                foreach ($menus as $menu) {
                    $qty = rand(1, 3);
                    $item = OrderItem::factory()->create([
                        'order_number' => $order->order_number,
                        'menu_id' => $menu->id,
                        'quantity' => $qty,
                        'price' => $menu->price,
                        'total_price' => $qty * $menu->price,
                    ]);
                    $total += $item->total_price;
                }

                $order->update([
                    'total_price' => $total,
                    'order_status' => collect(['menunggu konfirmasi', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->random(),
                ]);
            });
    }
}
