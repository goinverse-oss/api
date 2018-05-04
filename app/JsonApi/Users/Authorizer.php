<?php
/**
 * Created by IntelliJ IDEA.
 * User: Kenneth
 * Date: 2018-05-04
 * Time: 12:20 AM
 */

namespace App\JsonApi\Users;


use App\User;
use CloudCreativity\JsonApi\Authorizer\AbstractAuthorizer;
use CloudCreativity\JsonApi\Contracts\Object\RelationshipInterface;
use CloudCreativity\JsonApi\Contracts\Object\ResourceObjectInterface;
use Illuminate\Support\Facades\Auth;
use Neomerx\JsonApi\Contracts\Encoder\Parameters\EncodingParametersInterface;

class Authorizer extends AbstractAuthorizer
{
    /**
     * @param string $resourceType
     * @param ResourceObjectInterface $resource
     * @param EncodingParametersInterface $parameters
     * @return bool
     */
    public function canCreate($resourceType, ResourceObjectInterface $resource, EncodingParametersInterface $parameters)
    {
        return Auth::guest();
    }

    /**
     * @param User $record
     * @param EncodingParametersInterface $parameters
     * @return bool
     */
    public function canRead($record, EncodingParametersInterface $parameters)
    {
        $user = Auth::user();
        return $user && $user->id === $record->id;
    }

    /**
     * @param User $record
     * @param ResourceObjectInterface $resource
     * @param EncodingParametersInterface $parameters
     * @return bool
     */
    public function canUpdate($record, ResourceObjectInterface $resource, EncodingParametersInterface $parameters)
    {
        $user = Auth::user();
        return $user && $user->id === $record->id;
    }

    /**
     * @param User $record
     * @param EncodingParametersInterface $parameters
     * @return bool
     */
    public function canDelete($record, EncodingParametersInterface $parameters)
    {
        return false;
    }

    /**
     * @param string $resourceType
     * @param EncodingParametersInterface $parameters
     * @return bool
     */
    public function canReadMany($resourceType, EncodingParametersInterface $parameters)
    {
        return false;
    }

    /**
     * @param string $relationshipKey
     * @param User $record
     * @param RelationshipInterface $relationship
     * @param EncodingParametersInterface $parameters
     * @return bool
     */
    public function canModifyRelationship(
        $relationshipKey,
        $record,
        RelationshipInterface $relationship,
        EncodingParametersInterface $parameters
    )
    {
        $user = Auth::user();
        return $user && $user->id === $record->id;
    }
}