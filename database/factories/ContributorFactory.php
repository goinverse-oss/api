<?php

use Faker\Generator as Faker;

$factory->define(App\Contributor::class, function (Faker $faker) {
    $name = $faker->name;
    $userName = preg_replace('/\W/','', strtolower($name));
    return [
        'name' => $name,
        'bio' => $faker->paragraph,
        'image_url' => $faker->imageUrl(50,50),
        'url' => $faker->url,
        'twitter' => '@'.$userName,
        'facebook' => '/'.$userName
    ];
});