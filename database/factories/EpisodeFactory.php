<?php

use Faker\Generator as Faker;

$factory->define(App\Episode::class, function (Faker $faker) {
    return [
        'title' => ucwords(implode(' ',$faker->words)),
        'description' => $faker->text,
        'image_url' => $faker->imageUrl(),
        'media_url' => $faker->url,
        'player_url' => $faker->url,
        'permalink_url' => $faker->url,
        'published_at' => $faker->date(),
        'status' => $faker->randomElement(['published','draft']),
        'number' => $faker->randomDigitNotNull,
    ];
});