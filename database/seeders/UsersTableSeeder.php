<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
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
                'type' => '1',
                'email_verified_at' => now(),
            ]
        );
    }
}
