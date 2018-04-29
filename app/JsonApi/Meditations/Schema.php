<?php

namespace App\JsonApi\Meditations;

use App\Meditation;
use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;

class Schema extends EloquentSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'meditations';

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
        'media_url',
        'published_at',
        'status'
    ];

    /**
     * @param object $resource
     * @param bool $isPrimary
     * @param array $includeRelationships
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        if (!$resource instanceof Meditation) {
            throw new RuntimeException('Expecting a meditation model.');
        }

        return [
            'category' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::DATA => $resource->category,
            ],
            'contributors' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::META => function () use ($resource) {
                    return ['total' => $resource->contributors()->count()];
                },
                self::DATA => $resource->contributors,
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
