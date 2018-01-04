<?php

use App\Podcast;
use Faker\Factory;
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

        $faker = Factory::create();

        for ($i = 0; $i < 3; $i++) {
            $podcast = Podcast::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'image_url' => $faker->imageUrl()
            ]);
        }
    }
}
