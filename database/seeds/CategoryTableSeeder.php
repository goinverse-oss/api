<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        for ($i = 0; $i < 3; $i++) {
            Factory(Category::class)->create();
        }
    }
}
