<?php

namespace App\JsonApi\Contributors;

use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;

class Hydrator extends EloquentHydrator
{

    /**
     * @var array
     */
    protected $attributes = [
        'name',
        'bio',
        'image-url',
        'url',
        'twitter',
        'facebook',
    ];

    /**
     * @var array
     */
    protected $relationships = [
        'podcasts',
        'seasons',
        'episodes',
    ];
}
