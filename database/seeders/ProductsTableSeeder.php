<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProductsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'سقف متحرک پارچه ای',
            ],
            [
                'name' => 'سقف متحرک آلومینیومی',
                
            ],
            [
                'name' => 'سقف متحرک شیشه ای',
                
            ],
            [
                'name' => 'سقف پارچه ای آتین',
                
            ],
            [
                'name' => 'پنجره گیوتین',
                
            ],
            [
                'name' => 'پنجره اسلایدینگ',
                
            ],
            [
                'name' => 'پرده کابلی',
                
            ],
            [
                'name' => 'شید رول',
                
            ],

        ]);
    }
}
