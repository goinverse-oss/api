<?php

namespace App\Http\Controllers\Api;

use App\Utility\Inflect;
use CloudCreativity\JsonApi\Contracts\Http\Requests\RequestInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
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

        /** @var BelongsTo|HasMany|BelongsToMany|MorphToMany $relation */
        $relation = $model->{$key}();
        if(is_a($relation, BelongsTo::class)){
            if($request->getDocument()->getData()) {
                $relatedModel = $store->findRecord($request->getDocument()->getResource()->getIdentifier());
                $relation->associate($relatedModel)->save();
            } else {
                $relation->dissociate()->save();
            }
        } else {
            if (is_a($relation, HasMany::class)) {
                $belongsToMethodName = Inflect::singularize($request->getResourceType());
                foreach ($relation->getResults() as $related) {
                    if (method_exists($related, $belongsToMethodName)) {
                        $related->{$belongsToMethodName}()->dissociate()->save();
                    }
                }
            } else if (is_a($relation, BelongsToMany::class) || is_a($relation, MorphToMany::class)) {
                $model->{$key}()->detach();
            }

            $relatedModels = [];
            foreach ($request->getDocument()->getResources()->getAll() as $resourceObject) {
                $relatedModels[] = $store->findRecord($resourceObject->getIdentifier());
            }
            $model->refresh();
            $model->{$key}()->saveMany($relatedModels);
        }

        $model->refresh();

        return $this
            ->reply()
            ->relationship($model->{$key});
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

        $relation = $model->{$key}();
        if (is_a($relation, HasMany::class)) {
            $belongsToMethodName = Inflect::singularize($request->getResourceType());
            /** @var HasMany $relation */
            foreach ($relation->getResults() as $related) {
                if (in_array($related->id, $relatedIds) && method_exists($related, $belongsToMethodName)) {
                    $related->{$belongsToMethodName}()->dissociate()->save();
                }
            }
        } else if (is_a($relation, BelongsToMany::class) || is_a($relation, MorphToMany::class)) {
            $model->{$key}()->detach($relatedIds);
        }

        $model->refresh();

        return $this
            ->reply()
            ->relationship($model->{$key});
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
        $existingIds = [];
        foreach ($model->{$key} as $related) {
            $existingIds[] = $related->id;
        }
        foreach($request->getDocument()->getResources()->getAll() as $resourceObject) {
            if(!in_array($resourceObject->getId(), $existingIds)) {
                $relatedModels[] = $store->findRecord($resourceObject->getIdentifier());
            }
        }
        $model->{$key}()->saveMany($relatedModels);
        $model->refresh();

        return $this
            ->reply()
            ->relationship($model->{$key});
    }
}