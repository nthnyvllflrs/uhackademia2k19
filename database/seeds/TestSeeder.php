<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserInformation;
// use App\UserType;
use App\Report;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'password' => 'password',

            'full_name' => 'Juan Dela Cruz',
            'address' => 'Zamboanga City',
            'lat' => '6.919854',
            'lng' => '122.073427',
            'role' => 1,
        ]);
    }
}
