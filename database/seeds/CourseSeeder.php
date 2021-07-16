<?php

use Illuminate\Database\Seeder;
use App\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::insert([
            ['name' => 'Basic Math'],
            ['name' => 'Advance Math'],
            ['name' => 'Advance++ Math']
        ]);
    }
}
