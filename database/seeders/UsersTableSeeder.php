<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'parentName' => '松岡親太郎',
            'email' => 'tatataabcd@gmail.com',
            'tel' => '08099999999',
            'password' => \Hash::make('tarou0208'),
            'address' => '大阪',
            'introduction' => '区役所',
        ]);
    }
}
