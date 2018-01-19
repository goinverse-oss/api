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
        'has-many' => ['contributors'],
    ]);
    $api->resource('contributors', [
        'has-many' => ['podcasts']
    ]);
});



//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});




//Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function() {
//
//    Route::post('register', 'UsersController@create');
//
//});

//Route::group(['prefix' => 'v1', 'middleware' => 'auth:api', 'namespace' => 'Api'], function() {
//
//    Route::get('podcasts', 'PodcastsController@index');
//    Route::get('podcasts/{podcast}', 'PodcastsController@read');
//    Route::post('podcasts', 'PodcastsController@create');
//    Route::put('podcasts/{podcast}', 'PodcastsController@update');
//    Route::patch('podcasts/{podcast}', 'PodcastsController@update');
//    Route::delete('podcasts/{podcast}', 'PodcastsController@delete');
//
//});