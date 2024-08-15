<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'amin darabi',
                'email' => 'amdarabi@yahoo.com',
                'is_admin'=>'1',
                'password' => Hash::make('amdarabi'),
            ],
        ]);
    }
}
