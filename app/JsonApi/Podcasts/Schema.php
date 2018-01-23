<?php

namespace App\JsonApi\Podcasts;

use App\Podcast;
use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;

class Schema extends EloquentSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'podcasts';

    /**
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * @var array
     */
    protected $attributes = [
        'title',
        'description',
        'image_url',
    ];

    /**
     * @param object $resource
     * @param bool $isPrimary
     * @param array $includeRelationships
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        if (!$resource instanceof Podcast) {
            throw new RuntimeException('Expecting a podcast model.');
        }

        return [
        ];
    }

    /**
     * @return array
     */
    public function getIncludePaths()
    {
        return [
        ];
    }
}
