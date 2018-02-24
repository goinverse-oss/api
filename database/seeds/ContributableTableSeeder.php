<?php

use App\Category;
use App\Podcast;
use Illuminate\Database\Seeder;

class ContributableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contributables')->truncate();

        foreach (Podcast::all() as $podcast) {
            $podcast->contributors()->attach(array_unique([rand(1,10), rand(1,10), rand(1,10)]));
        }

        foreach (Category::all() as $category) {
            $category->contributors()->attach(array_unique([rand(1,10), rand(1,10), rand(1,10)]));
        }
    }
}

