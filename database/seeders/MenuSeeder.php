<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Category::count() === 0) {
            Category::factory()->count(5)->create();
        }

        Category::all()->each(function ($category) {
            Menu::factory()
                ->count(3)
                ->create(['category_id' => $category->category_id]);
        });
    }
}
