<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('menu_group')->truncate();
        $this->createMenuGroup();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return true;
    }

    public function createMenuGroup()
    {
        DB::table('menu_group')->insert([
            ['title' => 'menu đầu trang', 'position' => 'đầu trang','created_at' => now(), 'updated_at' => now()],
            ['title' => 'menu cuối trang', 'position' => 'cuối trang','created_at' => now(), 'updated_at' => now()],
        ]);
    }
}