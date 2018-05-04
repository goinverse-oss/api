<?php

namespace App\JsonApi\Users;

use App\User;
use CloudCreativity\JsonApi\Contracts\Object\ResourceObjectInterface;
use CloudCreativity\LaravelJsonApi\Hydrator\EloquentHydrator;

class Hydrator extends EloquentHydrator
{

    /**
     * @var array
     */
    protected $attributes = [
        'name',
        'email',
        'password',
    ];

    /**
     * @var array
     */
    protected $relationships = [];

    /**
     * @param ResourceObjectInterface $resource
     * @param User $record
     */
    protected function hydrated(ResourceObjectInterface $resource, $record)
    {
        $resourcePassword = $resource->getAttributes()->get('password');
        if($resourcePassword) {
            $record->fill(['password'=>bcrypt($resourcePassword)]);
        }
    }
}
