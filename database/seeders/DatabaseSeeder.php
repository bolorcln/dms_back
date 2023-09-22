<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            // GroupSeeder::class,
            // MenuSeeder::class,
            // SubMenuSeeder::class
        ]);

        // Menus
        $menu1 = Menu::factory()->create([
            'name' => 'Menu 1',
            'order' => 1
        ]);
        collect([
            ['name' => 'Submenu 1.1', 'order' => 1],
            ['name' => 'Submenu 1.3', 'order' => 3],
            ['name' => 'Submenu 1.2', 'order' => 2]
        ])->each(fn ($item) => SubMenu::factory()->create([
            'name' => $item['name'],
            'order' => $item['order'],
            'parent_id' => $menu1
        ]));

        $menu2 = Menu::factory()->create([
            'name' => 'A Menu 2',
            'order' => 2
        ]);
        collect([
            ['name' => 'Submenu 2.3', 'order' => 3],
            ['name' => 'Submenu 2.1', 'order' => 1],
            ['name' => 'Submenu 2.2', 'order' => 2]
        ])->each(fn ($item) => SubMenu::factory()->create([
            'name' => $item['name'],
            'order' => $item['order'],
            'parent_id' => $menu2
        ]));

        $menu3 = Menu::factory()->create([
            'name' => 'C Menu 3',
            'order' => 3
        ]);
    }
}
