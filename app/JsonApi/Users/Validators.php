<?php

namespace App\JsonApi\Users;

use App\User;
use CloudCreativity\JsonApi\Contracts\Validators\RelationshipsValidatorInterface;
use CloudCreativity\LaravelJsonApi\Validators\AbstractValidatorProvider;
use Illuminate\Validation\Rule;

class Validators extends AbstractValidatorProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'users';

    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
        'id',
    ];

    /**
     * @var array
     */
    protected $allowedIncludePaths = [];

    /**
     * Get the validation rules for the resource attributes.
     *
     * @param User|null $record
     *      the record being updated, or null if it is a create request.
     * @return array
     */
    protected function attributeRules($record = null)
    {
        $required = $record ? 'sometimes|required' : 'required';

        /**
         * @see https://laravel.com/docs/5.5/validation#available-validation-rules
         */
        return [
            'name' => "$required|string|min:1",
            'email' => ($record ? [
                'sometimes', 'required', 'string', 'min:1', 'email',
                Rule::unique('users')->ignore($record->id)
            ] : 'required|string|min:1|email|unique:users'),
            'password' => "$required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z]).*$/"
        ];
    }

    /**
     * @inheritdoc
     */
    protected function relationshipRules(RelationshipsValidatorInterface $relationships, $record = null)
    {
    }

}
