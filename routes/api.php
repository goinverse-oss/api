<?php

use CloudCreativity\LaravelJsonApi\Routing\ApiGroup as Api;
use CloudCreativity\LaravelJsonApi\Facades\JsonApi;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

JsonApi::register('v1', ['namespace' => 'Api', 'id' => '[\d]+'], function (Api $api) {
    $api->resource('podcasts', [
        'has-many' => ['seasons','contributors'],
    ]);
    $api->resource('seasons', [
        'has-one' => ['podcast'],
        'has-many' => ['contributors'],
    ]);
    $api->resource('episodes', [
        'has-many' => ['contributors'],
    ]);
    $api->resource('contributors', [
        'has-many' => ['podcasts','seasons']
    ]);
});