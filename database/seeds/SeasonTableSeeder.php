<?php

use App\Podcast;
use App\Season;
use Illuminate\Database\Seeder;

class SeasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Season::truncate();

        foreach (Podcast::all() as $podcast) {
            for ($i = 0; $i < 3; $i++) {
                /** @var Season $season */
                $season = Factory(Season::class)->make();
                $season->podcast()->associate($podcast);
                $season->save();
            }
        }
    }
}
