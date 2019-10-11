<?php

use App\User;
use App\Report;
use App\Resident;
use App\Barangay;
use App\Collector;
use Illuminate\Database\Seeder;

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
            'full_name' => 'Michael Scott',
            'role' => 0,
        ]);

        User::create([
            'username' => 'resident',
            'password' => 'password',
            'full_name' => 'Juan dela Cruz',   
            'role' => 1,
        ]);
        Resident::create([
            'user_id' => 2,
            'contact_number' => "09000000001",
            'address' => 'Zamboanga City',
            'barangay_id' => 1,
            'lat' => '6.919854',
            'lng' => '122.073427',
        ]);

        User::create([
            'username' => 'barangay',
            'password' => 'password',
            'full_name' => 'Ginoong Kagawad',
            'role' => 2,
        ]);
        Barangay::create([
            'user_id' => 2,
            'name' => 'Putik',
        ]);

        User::create([
            'username' => 'collector',
            'password' => 'password',
            'full_name' => 'Cardo Dalisay',
            'role' => 3,
        ]);
        Collector::create([
            'user_id' => 3,
            'barangay_id' => 1,
            'license_num' => '000-00000000-000',
            'plate_num' => 'ABC 123',
            'location' => 'Putik',
            'lat' => '6.919874',
            'lng' => '122.073457',
            'last_updated' => '2019-10-11 16:06:00',
        ]);

    }
}
