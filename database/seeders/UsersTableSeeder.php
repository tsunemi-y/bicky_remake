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
            'parentName' => '松岡太郎',
            'email' => 'tatataabcd@gmail.com',
            'password' => 'tarou0208',
            'childName' => '松岡祐太',
            'age' => '5',
            'gender' => '男',
            'diagnosis' => 'ASD',
            'address' => '大阪',
            'introduction' => '区役所',
            'parentName' => '松岡太郎',
            'parentName' => '松岡太郎',
        ]);
    }
}
