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
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@paper.com',
                'phone' => 3024024838,
                'password' => Hash::make("admin123"),
                'role' => 'admin'
            ],
            [
                'name' => 'Test User',
                'email' => 'user@paper.com',
                'phone' => 3369237827,
                'password' => Hash::make("test123"),
                'role' => 'user'
            ],
        ];

        DB::table('users')->insert($users);
    }
}
