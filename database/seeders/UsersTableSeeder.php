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
            'password' => \Hash::make('tarou0208'),
            'childName' => '松岡子太郎',
            'age' => '5',
            'gender' => '男',
            'diagnosis' => 'ASD',
            'childName2' => '松岡2子太郎',
            'age2' => '3',
            'gender2' => '女',
            'diagnosis2' => 'ADHD',
            'address' => '大阪',
            'introduction' => '区役所',
            'coursePlan' => 1,
            'fee' => '7700',
        ]);
    }
}
