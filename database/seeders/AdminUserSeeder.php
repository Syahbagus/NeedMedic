<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@needmedic.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'gender' => 'male',
                'date_of_birth' => '2004-04-21',
                'address' => 'Giri Santika',
                'City' => 'Surabaya',
                'contact_no' => '083851716161',
                'paypal_id' => 'tes@gmail.com',
                'role' => 'admin',
            ]
        );
    }
}
