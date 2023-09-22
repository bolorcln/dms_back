<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menu1 = Menu::factory()->create([
            'name' => 'Menu 1',
            'order' => 1
        ]);

        $menu2 = Menu::factory()->create([
            'name' => 'Menu 2',
            'order' => 2
        ]);

        $menu3 = Menu::factory()->create([
            'name' => 'Menu 3',
            'order' => 3
        ]);
    }
}
