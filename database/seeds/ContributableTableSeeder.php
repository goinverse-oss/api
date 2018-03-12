<?php

use App\Podcast;
use App\Season;
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
        foreach (Season::all() as $season) {
            $season->contributors()->attach(array_unique([rand(1,10), rand(1,10), rand(1,10)]));
        }
    }
}

