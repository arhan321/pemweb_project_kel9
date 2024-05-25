<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'created_at'     => Carbon::create(2024, 1, 1), // January 2024
            ],
            [
                'id'             => 2,
                'name'           => 'arhan malik alrasyid',
                'email'          => 'arhanmali96@gmail.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'created_at'     => Carbon::create(2024, 1, 2), // january 2024
            ],
            [
                'id'             => 3,
                'name'           => 'febru',
                'email'          => 'febru@gmail.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'created_at'     => Carbon::create(2024, 1, 3), //january 2024
            ],
            [
                'id'             => 4,
                'name'           => 'enep',
                'email'          => 'enep@gmail.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'created_at'     => Carbon::create(2024, 1, 4), // january 2024
            ],
            [
                'id'             => 5,
                'name'           => 'fathan',
                'email'          => 'fathanghani27@gmail.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'created_at'     => Carbon::create(2024, 2, 1), // feb 2024
            ],
            [
                'id'             => 6,
                'name'           => 'adella',
                'email'          => 'adella@gmail.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'created_at'     => Carbon::create(2024, 2, 1), // feb 2024
            ],
            [
                'id'             => 7,
                'name'           => 'fiolin',
                'email'          => 'fiolin@gmail.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'created_at'     => Carbon::create(2024, 2, 1), // feb 2024
            ],
        ];

        User::insert($users);
    }
}
