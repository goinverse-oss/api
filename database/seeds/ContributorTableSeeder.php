<?php

use App\Contributor;
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

        for ($i = 0; $i < 10; $i++) {
            Factory(Contributor::class)->create();
        }
    }
}
