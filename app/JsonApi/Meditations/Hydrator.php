<?php

namespace App\JsonApi\Meditations;

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
        'published-at',
        'status',
    ];

    protected $dates = [
        'created-at',
        'updated-at',
        'published-at',
    ];

    /**
     * @var array
     */
    protected $relationships = [
        'category',
        'contributors',
    ];
}
