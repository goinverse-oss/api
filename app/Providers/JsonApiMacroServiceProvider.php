<?php

namespace App\Providers;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class JsonApiMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Response::macro('jsonApi', [$this, 'createJsonApiDataResponse']);
        Response::macro('jsonApiError', [$this, 'createJsonApiErrorsResponse']);
    }

    public function createJsonApiDataResponse($data, $status = 200, $headers = [], $included = null, $meta = null) {
        return $this->createJsonApiResponse($data, null, $meta, $included, $status, $headers);
    }

    public function createJsonApiErrorsResponse($errors, $status = 500, $headers = []) {
        return $this->createJsonApiResponse(null, $errors, null, null, $status, $headers);
    }

    protected function createJsonApiResponse($data, $errors, $meta, $included, $status, $headers) {

        $content = ['data' => $this->convertData($data)];
        if(isset($meta)) {
            $content['meta'] = $meta;
        }
        $content['jsonapi'] = ['version'=>"1.0"];
        $headers['Content-Type'] = 'application/vnd.api+json';

        return Response::make(json_encode($content), $status, $headers);

    }

    protected function convertData($rawData)
    {
        if (is_a($rawData, Model::class)) {
            $data = $this->modelToResource($rawData);
        } elseif ($rawData instanceof Arrayable) {
            $dataAsArray = $rawData->toArray();
            return $this->convertData($dataAsArray);
        } else if (is_array($rawData)) {
            $data = [];
            foreach ($rawData as $rawDatum) {
                if (is_a($rawDatum, Model::class)) {
                    $data[] = $this->modelToResource($rawDatum);
                } else {
                    $data[] = $rawDatum;
                }
            }
        } else {
            $data = $rawData;
        }

        return $data;
    }

    protected function modelToResource(Model $model)
    {
        $attributes = $model->attributesToArray();
        $id = $attributes['id'];
        unset($attributes['id']);
        $type = strtolower(class_basename($model));

        $data = [
            'type' => $type,
            'id' => $id,
            'attributes' => $attributes
        ];

        return $data;
    }
}