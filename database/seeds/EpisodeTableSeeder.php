<?php

use App\Episode;
use App\Season;
use Illuminate\Database\Seeder;

class EpisodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Episode::truncate();

        foreach(Season::all() as $season) {
            for ($i = 0; $i < 3; $i++) {
                /** @var Episode $episode */
                $episode = Factory(Episode::class)->create();
                $episode->season()->associate($season);
                $episode->save();
            }
        }
    }
}
