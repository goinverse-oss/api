<?php

namespace App\JsonApi\Meditations;

use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;
use CloudCreativity\LaravelJsonApi\Validators\AbstractValidatorProvider;

class Validators extends AbstractValidatorProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'meditations';

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
        'contributors',
        'category'
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
            'published-at' => "date|nullable",
            'status' => "$required|string|in:publish,draft|nullable",
        ];
    }

    /**
     * @inheritdoc
     */
    protected function relationshipRules(RelationshipsValidatorInterface $relationships, $record = null)
    {
        $relationships
            ->hasOne('category', 'categories', false, true, null)
            ->hasMany('contributors', 'contributors', false, true, null);
    }

}
