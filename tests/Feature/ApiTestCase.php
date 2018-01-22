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
    protected function doReadRelatedResource($resourceId, $relationshipKey, array $params = [], array $headers = [])
    {
        $params = $this->addDefaultRouteParams($params);
        $uri = $this->api()->url()->relatedResource($this->resourceType(), $resourceId, $relationshipKey, $params);

        return $this->getJsonApi($uri, [], $headers);
    }

    /**
     * @param mixed $resourceId
     * @param string $relationshipKey
     * @param array $data
     * @param array $params
     * @param array $headers
     * @return TestResponse
     */
    protected function doCreateRelatedResource($resourceId, $relationshipKey, array $data, array $params = [], array $headers = [])
    {
        $params = $this->addDefaultRouteParams($params);
        $uri = $this->api()->url()->relatedResource($this->resourceType(), $resourceId, $relationshipKey, $params);

        return $this->patchJsonApi($uri, ['data' => $data], $headers);
    }
}