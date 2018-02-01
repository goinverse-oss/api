<?php

namespace App\JsonApi\Episodes;

use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;
use CloudCreativity\LaravelJsonApi\Validators\AbstractValidatorProvider;

class Validators extends AbstractValidatorProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'episodes';

    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
        'id',
    ];

    /**
     * @var array
     */
    protected $allowedIncludePaths = [
        'contributors'
    ];

    /**
     * @inheritDoc
     */
    protected function attributeRules($record = null)
    {
        $required = $record ? 'sometimes|required' : 'required';

        /**
         * @see https://laravel.com/docs/5.5/validation#available-validation-rules
         */
        return [
            'title' => "$required|string|min:1",
            'description' => "$required|string|min:1|nullable",
            'image-url' => "$required|string|min:1|nullable",
            'media-url' => "$required|string|min:1|nullable",
            'player-url' => "$required|string|min:1|nullable",
            'permalink-url' => "$required|string|min:1|nullable",
            'published-at' => "$required|date:c|nullable",
            'status' => "$required|string|in:published,draft|nullable",
            'season-episode-number' => "$required|integer|nullable",
        ];
    }

    /**
     * @inheritdoc
     */
    protected function relationshipRules(RelationshipsValidatorInterface $relationships, $record = null)
    {
        $relationships->hasMany(
            'contributors',
            'contributors',
            false,
            true,
            null
            );
    }

}
