<?php

namespace App\JsonApi\Episodes;

use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;

class Hydrator extends EloquentHydrator
{

    /**
     * @var array
     */
    protected $attributes = [
        'title',
        'description',
        'image-url',
        'media-url',
        'player-url',
        'permalink-url',
        'published-at',
        'status',
        'number',
    ];

    /**
     * @var array
     */
    protected $relationships = [
        'season',
        'contributors',
    ];
}
