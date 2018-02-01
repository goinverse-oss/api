<?php

namespace App\JsonApi\Contributors;

use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;
use CloudCreativity\LaravelJsonApi\Validators\AbstractValidatorProvider;

class Validators extends AbstractValidatorProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'contributors';

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
        'podcasts',
        'seasons'
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
            'name' => "$required|string|min:1",
            'bio' => "$required|string|min:1|nullable",
            'image-url' => "$required|string|min:1|nullable",
            'url' => "$required|string|min:1|nullable",
            'twitter' => "$required|string|min:1|nullable",
            'facebook' => "$required|string|min:1|nullable",
        ];
    }

    /**
     * @inheritDoc
     */
    protected function relationshipRules(RelationshipsValidatorInterface $relationships, $record = null)
    {
        $relationships
            ->hasMany('podcasts', 'podcasts', false, true, null)
            ->hasMany('seasons', 'seasons', false, true, null)
            ->hasMany('episodes', 'episodes', false, true, null);
    }

}
