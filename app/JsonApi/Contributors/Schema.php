<?php

namespace App\JsonApi\Contributors;

use App\Contributor;
use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;

class Schema extends EloquentSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'contributors';

    /**
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * @var array
     */
    protected $attributes = [
        'name',
        'bio',
        'image_url',
        'url',
        'twitter',
        'facebook',
    ];

    /**
     * @param object $resource
     * @param bool $isPrimary
     * @param array $includeRelationships
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        if (!$resource instanceof Contributor) {
            throw new RuntimeException('Expecting a contributor model.');
        }

        return [
        ];
    }

    /**
     * @return array
     */
    public function getIncludePaths()
    {
        return [];
    }
}
