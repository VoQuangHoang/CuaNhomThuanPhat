<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('settings')->truncate();
        $this->createOption();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return true;
    }
    public function createOption()
    {
        // $content = json_encode(
        //     [
        //         'favicon' => '/backend/images/logo.png',
        //         'logo' => '/backend/images/logobaby.png',
        //         'title' => 'Admin',
        //         'title_login' => 'Login',
        //         'site_keyword' => 'Dotiva',
        //         'site_title' => 'Dotiva',
        //         'site_description' => 'Dotiva',
        //         'logo_share' => '/backend/images/logo.png',
        //     ]
        // );
        DB::table('settings')->insert([
            [
                'type' => 'general', 'content' => '',
                'created_at' => now(), 'updated_at' => now()],
            [
                'type' => 'css-js-config','content' => '',
                'created_at' => now(),'updated_at' => now() ],
            [
                'type' => 'smtp-config','content' => '',
                'created_at' => now(),'updated_at' => now() ],
        ]);
    }
}
