<?php

use App\Podcast;
use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});




Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function() {

    Route::post('register', 'UsersController@create');

});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api', 'namespace' => 'Api'], function() {

    Route::get('podcasts', 'PodcastsController@index');
    Route::get('podcasts/{podcast}', 'PodcastsController@read');
    Route::post('podcasts', 'PodcastsController@create');
    Route::put('podcasts/{podcast}', 'PodcastsController@update');
    Route::patch('podcasts/{podcast}', 'PodcastsController@update');
    Route::delete('podcasts/{podcast}', 'PodcastsController@delete');

});