<?php

use App\Podcast;
use Illuminate\Database\Seeder;

class PodcastTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Podcast::truncate();

        for ($i = 0; $i < 3; $i++) {
            Factory(Podcast::class)->create();
        }
    }
}
