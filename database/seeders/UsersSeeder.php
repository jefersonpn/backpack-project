<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'jefersonpn@gmail.com',
            ],
            [
                'name' => 'Jeferson',
                'lastname' => 'Nascimento',
                'password' =>  Hash::make('Intellp4'),
                'phone' => '3517659040',
                'email_verified_at' => now(),
            ]
        );
    }
}
