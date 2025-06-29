<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CustomerAddress;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan user tersedia
        if (User::count() === 0) {
            User::factory()->count(5)->create();
        }

        // Buat 2 alamat untuk setiap user
        User::all()->each(function ($user) {
            CustomerAddress::factory()
                ->count(2)
                ->create(['user_id' => $user->id]);
        });
    }
}
