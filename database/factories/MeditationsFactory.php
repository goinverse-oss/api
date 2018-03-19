<?php

use Faker\Generator as Faker;

$factory->define(App\Meditation::class, function (Faker $faker) {
    if($faker->boolean()) {
        $status = 'publish';
        $published_at = $faker->date();
    } else {
        $status = 'draft';
        $published_at = null;
    }
    return [
        'title' => ucwords(implode(' ',$faker->words)),
        'description' => $faker->text,
        'image_url' => $faker->imageUrl(),
        'media_url' => $faker->url(),
        'published_at' => $published_at,
        'status' => $status,
    ];
});