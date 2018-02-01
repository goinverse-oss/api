<?php

namespace App\JsonApi\Seasons;

use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;
use CloudCreativity\LaravelJsonApi\Validators\AbstractValidatorProvider;

class Validators extends AbstractValidatorProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'seasons';

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
        'podcast',
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
            'number' => "$required|integer|nullable",
        ];
    }

    /**
     * @inheritdoc
     */
    protected function relationshipRules(RelationshipsValidatorInterface $relationships, $record = null)
    {
        $relationships
            ->hasOne('podcast', 'podcasts', false, false, null)
            ->hasMany('contributors', 'contributors', false, true, null);
    }

}
