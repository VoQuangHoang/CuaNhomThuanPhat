<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        $this->createUser();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return true;
    }
    public function createUser()
    {
        DB::table('users')->insert([
            'name' => 'Dotiva admin',
            'image' => '/backend/images/default.jpg',
            'phone' => '0123456789',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('JKSadmin123@'),
            'active' => 1, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
