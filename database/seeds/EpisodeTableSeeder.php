<?php

use App\Episode;
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

        for ($i = 0; $i < 3; $i++) {
            Factory(Episode::class)->create();
        }
    }
}
