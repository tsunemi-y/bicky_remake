<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 通常プラン
        Course::create(['name' => 'お一人様コース']);
        Course::create(['name' => '兄弟同時コース']);
        Course::create(['name' => '兄弟分離コース']);

        // 中学生限定短期プラン
        Course::create(['name' => '中学生限定通常コース']);
        Course::create(['name' => '中学生限定特進コース']);
    }
}
