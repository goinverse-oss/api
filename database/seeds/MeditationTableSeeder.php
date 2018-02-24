<?php

use App\Category;
use App\Meditation;
use Illuminate\Database\Seeder;

class MeditationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meditation::truncate();

        foreach (Category::all() as $category) {
            for ($i = 0; $i < 3; $i++) {
                $meditation = Factory(Meditation::class)->create();
                $meditation->category()->associate($category);
                $meditation->save();
            }
        }
    }
}
