<?php

namespace App\JsonApi\Users;

use App\User;
use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;

class Schema extends EloquentSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'users';

    /**
     * @var string
     */
    protected $dateFormat = 'c';

    /**
     * @var array
     */
    protected $attributes = [
        'name',
        'email',
    ];

    /**
     * @param object $resource
     * @param bool $isPrimary
     * @param array $includeRelationships
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        if (!$resource instanceof User) {
            throw new RuntimeException('Expecting a user model.');
        }

        return [];
    }

    /**
     * @return array
     */
    public function getIncludePaths()
    {
        return [];
    }
}
