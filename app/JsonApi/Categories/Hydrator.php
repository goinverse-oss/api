<?php

namespace App\JsonApi\Categories;

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
    ];

    /**
     * @var array
     */
    protected $relationships = [
        'contributors',
    ];
}
