<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([

            // Admin
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
            ],

            // User
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('123456'),
            ],
        ]);
        DB::table('accounts')->insert([

            // Admin
            [
                'user_id' => 1,
                'balance' => 0,
            ],

            // User
            [
                'user_id' => 2,
                'balance' => 0,
            ],
        ]);
    }
}
