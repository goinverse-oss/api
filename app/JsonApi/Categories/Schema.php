<?php

namespace App\JsonApi\Categories;

use App\Category;
use CloudCreativity\JsonApi\Exceptions\RuntimeException;
use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;

class Schema extends EloquentSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'categories';

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
        if (!$resource instanceof Category) {
            throw new RuntimeException('Expecting a category model.');
        }

        return [
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
