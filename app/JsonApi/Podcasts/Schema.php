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
    protected $dateFormat = 'c';

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
            'seasons' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::META => function () use ($resource) {
                    return ['total' => $resource->seasons()->count()];
                },
                self::DATA => $resource->seasons
            ],
            'contributors' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::META => function () use ($resource) {
                    return ['total' => $resource->contributors()->count()];
                },
                self::DATA => $resource->contributors
            ],
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
