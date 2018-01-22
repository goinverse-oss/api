<?php

namespace App\Http\Controllers\Api;

use CloudCreativity\JsonApi\Contracts\Http\Requests\RequestInterface;
use Illuminate\Http\Response;
use CloudCreativity\LaravelJsonApi\Http\Controllers\EloquentController as BaseEloquentController;

class EloquentController extends BaseEloquentController
{
    /**
     * @param RequestInterface $request
     * @return Response
     */
    public function replaceRelationship(RequestInterface $request)
    {
        $model = $this->getRecord($request);
        $key = $this->keyForRelationship($request->getRelationshipName());

        $store = $this->api()->getStore();
        $relatedModels = [];
        foreach($request->getDocument()->getResources()->getAll() as $resourceObject) {
            $relatedModels[] = $store->findRecord($resourceObject->getIdentifier());
        }
        $model->{$key}()->detach();
        $model->{$key}()->saveMany($relatedModels);

        return $this
            ->reply()
            ->content($model->{$key});
    }

    /**
     * @param RequestInterface $request
     * @return Response
     */
    public function removeFromRelationship(RequestInterface $request)
    {
        $model = $this->getRecord($request);
        $key = $this->keyForRelationship($request->getRelationshipName());

        $relatedIds = [];
        foreach($request->getDocument()->getResources()->getAll() as $resourceObject) {
            $relatedIds[] = $resourceObject->getId();
        }
        $model->{$key}()->detach($relatedIds);

        return $this
            ->reply()
            ->content($model->{$key});
    }

    /**
     * @param RequestInterface $request
     * @return Response
     */
    public function addToRelationship(RequestInterface $request)
    {
        $model = $this->getRecord($request);
        $key = $this->keyForRelationship($request->getRelationshipName());

        $store = $this->api()->getStore();
        $relatedModels = [];
        $existingIds = $model->{$key}()->allRelatedIds()->all();
        foreach($request->getDocument()->getResources()->getAll() as $resourceObject) {
            if(!in_array($resourceObject->getId(), $existingIds)) {
                $relatedModels[] = $store->findRecord($resourceObject->getIdentifier());
            }
        }
        $model->{$key}()->saveMany($relatedModels);

        return $this
            ->reply()
            ->content($model->{$key});
    }
}