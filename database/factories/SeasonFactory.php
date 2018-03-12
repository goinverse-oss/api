<?php

use Faker\Generator as Faker;

$factory->define(App\Season::class, function (Faker $faker) {
    return [
        'title' => ucwords(implode(' ',$faker->words)),
        'description' => $faker->text,
        'image_url' => $faker->imageUrl(),
        'number' => $faker->randomDigitNotNull
    ];
});