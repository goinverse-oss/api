<?php

use App\Contributor;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ContributorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contributor::truncate();

        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $name = $faker->name;
            $userName = preg_replace('/\W/','', strtolower($name));
            Contributor::create([
                'name' => $name,
                'bio' => $faker->paragraph,
                'image_url' => $faker->imageUrl(50,50),
                'url' => $faker->url,
                'twitter' => '@'.$userName,
                'facebook' => '/'.$userName
            ]);
        }
    }
}
