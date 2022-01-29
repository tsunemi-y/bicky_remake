<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(ReservationTableSeeder::class);
        $this->call(AvailableReservationDatetimesTableSeeder::class);
        $this->call(FeesTableSeeder::class);
    }
}
