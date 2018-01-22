<?php

namespace Tests\Feature;


use CloudCreativity\LaravelJsonApi\Testing\InteractsWithModels;
use CloudCreativity\LaravelJsonApi\Testing\MakesJsonApiRequests;
use CloudCreativity\LaravelJsonApi\Testing\TestResponse;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase as BaseTestCase;

class ApiTestCase extends BaseTestCase
{
    use MakesJsonApiRequests,
        InteractsWithModels,
        DatabaseTransactions;

    /**
     * @var string
     */
    protected $api = 'v1';

    /**
     * @param mixed $resourceId
     * @param string $relationshipKey
     * @param array $params
     * @param array $headers
     * @return TestResponse
     */
    protected function doReadRelatedResources($resourceId, $relationshipKey, array $params = [], array $headers = [])
    {
        $params = $this->addDefaultRouteParams($params);
        $uri = $this->api()->url()->relatedResource($this->resourceType(), $resourceId, $relationshipKey, $params);

        return $this->getJsonApi($uri, [], $headers);
    }

    /**
     * @param mixed $resourceId
     * @param string $relationshipKey
     * @param string $relatedType
     * @param array $relatedIds
     * @param array $params
     * @param array $headers
     * @return TestResponse
     */
    protected function doAddRelatedResources($resourceId, $relationshipKey, $relatedType, array $relatedIds, array $params = [], array $headers = [])
    {
        $params = $this->addDefaultRouteParams($params);
        $uri = $this->api()->url()->readRelationship($this->resourceType(), $resourceId, $relationshipKey, $params);

        $data = [];
        foreach ($relatedIds as $relatedId) {
            $data[] = ['type' => $relatedType, 'id' => (string) $relatedId];
        }

        return $this->postJsonApi($uri, ['data' => $data], $headers);
    }

    /**
     * @param mixed $resourceId
     * @param string $relationshipKey
     * @param string $relatedType
     * @param array $relatedIds
     * @param array $params
     * @param array $headers
     * @return TestResponse
     */
    protected function doRemoveRelatedResources($resourceId, $relationshipKey, $relatedType, array $relatedIds, array $params = [], array $headers = [])
    {
        $params = $this->addDefaultRouteParams($params);
        $uri = $this->api()->url()->readRelationship($this->resourceType(), $resourceId, $relationshipKey, $params);

        $data = [];
        foreach ($relatedIds as $relatedId) {
            $data[] = ['type' => $relatedType, 'id' => (string) $relatedId];
        }

        return $this->deleteJsonApi($uri, ['data' => $data], $headers);
    }

    /**
     * @param mixed $resourceId
     * @param string $relationshipKey
     * @param string $relatedType
     * @param array $relatedIds
     * @param array $params
     * @param array $headers
     * @return TestResponse
     */
    protected function doReplaceRelatedResources($resourceId, $relationshipKey, $relatedType, array $relatedIds, array $params = [], array $headers = [])
    {
        $params = $this->addDefaultRouteParams($params);
        $uri = $this->api()->url()->readRelationship($this->resourceType(), $resourceId, $relationshipKey, $params);

        $data = [];
        foreach ($relatedIds as $relatedId) {
            $data[] = ['type' => $relatedType, 'id' => (string) $relatedId];
        }

        return $this->patchJsonApi($uri, ['data' => $data], $headers);
    }

    protected function assertRelationshipsResponse(array $data)
    {
    }
}