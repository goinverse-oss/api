<?php

namespace App\JsonApi\Episodes;

use App\Episode;
use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;

class Schema extends EloquentSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'episodes';

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
        'player_url',
        'permalink_url',
        'published_at',
        'status',
        'season_episode_number',
    ];

    /**
     * @param object $resource
     * @param bool $isPrimary
     * @param array $includeRelationships
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        if (!$resource instanceof Episode) {
            throw new RuntimeException('Expecting an episode model.');
        }

        return [
            'contributors' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::META => function () use ($resource) {
                    return ['total' => $resource->contributors()->count()];
                },
                self::DATA => isset($includeRelationships['contributors']) ?
                    $resource->contributors : $this->createBelongsToIdentity($resource, 'contributors'),
            ],
        ];
    }

    /**
     * @return array
     */
    public function getIncludePaths()
    {
        return [
            'contributors'
        ];
    }
}
