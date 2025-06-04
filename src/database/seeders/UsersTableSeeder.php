<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->create();

        User::create([
            'name' => 'test1',
            'email' => 'test1@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'test2',
            'email' => 'test2@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'test3',
            'email' => 'test3@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
    }
}
