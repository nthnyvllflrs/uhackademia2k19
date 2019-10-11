<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserInformation;
use App\UserType;
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
        UserType::create([
            'name' => 'admin',
            'description' => 'Administrator',
        ]);

        User::create([
            'username' => 'admin',
            'password' => 'password',
            'user_type_id' => 1,
        ]);

        UserInformation::create([
            'user_id' => 1,
            'firstname' => 'Juan',
            'lastname' => 'Dela Cruz',
            'address' => 'Zamboanga City',
            'latitude' => '6.919854',
            'longitude' => '122.073427',
        ]);
    }
}
