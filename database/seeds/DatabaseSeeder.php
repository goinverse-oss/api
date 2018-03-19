<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(ContributorTableSeeder::class);
        $this->call(PodcastTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(MeditationTableSeeder::class);
        $this->call(SeasonTableSeeder::class);
        $this->call(EpisodeTableSeeder::class);
        $this->call(ContributableTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
