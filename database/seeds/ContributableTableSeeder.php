<?php

use App\Category;
use App\Episode;
use App\Meditation;
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

        /** @var Podcast $podcast */
        foreach (Podcast::all() as $podcast) {
            $podcastContributorIds = array_unique([rand(1,10), rand(1,10)]);
            $podcast->contributors()->attach($podcastContributorIds);

            /** @var Season $season */
            foreach ($podcast->seasons as $season) {
                $seasonContributorIds = array_unique(array_merge($podcastContributorIds,[rand(1,10), rand(1,10)]));
                $season->contributors()->attach($seasonContributorIds);

                /** @var Episode $episode */
                foreach ($season->episodes as $episode) {
                    $episodeContributorIds = array_unique(array_merge($seasonContributorIds,[rand(1,10), rand(1,10)]));
                    $episode->contributors()->attach($episodeContributorIds);
                }
            }
        }

        /** @var Category $category */
        foreach (Category::all() as $category) {
            $categoryContributorIds = array_unique([rand(1,10), rand(1,10)]);
            $category->contributors()->attach($categoryContributorIds);

            /** @var Meditation $meditation */
            foreach ($category->meditations as $meditation) {
                $meditationContributorId = $categoryContributorIds[array_rand($categoryContributorIds)];
                $meditation->contributors()->attach($meditationContributorId);
            }
        }
    }
}

