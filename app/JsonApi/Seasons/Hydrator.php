<?php

namespace App\JsonApi\Seasons;

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
        'number',
    ];

    /**
     * @var array
     */
    protected $relationships = [
        'podcast',
        'contributors',
    ];
}
