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
        'image_url',
        'media_url',
        'published_at',
        'status',
    ];

    /**
     * @var array
     */
    protected $relationships = [
        'category',
        'contributors',
    ];
}
