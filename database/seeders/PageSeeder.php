<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('pages')->truncate();
        $this->createPage();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return true;
    }
    public function createPage()
    {
        DB::table('pages')->insert([
            [
                'type' => 'home', 'content' => '', 'route' => 'home.index', 'name_page' => 'Trang chủ',
                'created_at' => now(), 'updated_at' => now(), 
            ],
            [
                'type' => 'about', 'content' => '', 'route' => 'home.about', 'name_page' => 'Giới thiệu',
                'created_at' => now(),'updated_at' => now() 
            ],
            [
                'type' => 'posts', 'content' => '', 'route' => 'home.posts', 'name_page' => 'Tin tức',
                'created_at' => now(),'updated_at' => now() 
            ],
            [
                'type' => 'brands', 'content' => '', 'route' => 'home.brands', 'name_page' => 'Thương hiệu',
                'created_at' => now(),'updated_at' => now() 
            ],
            [
                'type' => 'shopping_guide', 'content' => '', 'route' => 'home.shopping_guide', 'name_page' => 'Hướng dẫn mua hàng',
                'created_at' => now(),'updated_at' => now() 
            ],
            [
                'type' => 'privacy_policy', 'content' => '', 'route' => 'home.privacy_policy', 'name_page' => 'Chính sách bảo mật thông tin',
                'created_at' => now(),'updated_at' => now() 
            ],
            [
                'type' => 'return_policy', 'content' => '', 'route' => 'home.return_policy', 'name_page' => 'Chính sách đổi trả',
                'created_at' => now(),'updated_at' => now() 
            ],
            [
                'type' => 'member_policy', 'content' => '', 'route' => 'home.member_policy', 'name_page' => 'Chính sách thành viên',
                'created_at' => now(),'updated_at' => now() 
            ],
            [
                'type' => 'shipping_policy', 'content' => '', 'route' => 'home.shipping_policy', 'name_page' => 'Chính sách vận chuyển',
                'created_at' => now(),'updated_at' => now() 
            ],
            [
                'type' => 'point_policy', 'content' => '', 'route' => 'home.point_policy', 'name_page' => 'Chính sách tích điểm',
                'created_at' => now(),'updated_at' => now() 
            ],
        ]);
    }
}
