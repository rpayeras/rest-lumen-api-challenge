<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

$router->get('/', function () use ($router) {
//    return $router->app->version();
    return "Challenge Api";
});

$router->group([
    'prefix' => 'auth'
], function ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');

    Route::group(['middleware' => 'auth'], function($router) {
//        $router->post('logout', 'AuthController@logout');
        $router->post('refresh', 'AuthController@refresh');
//        $router->post('me', 'AuthController@me');
    });
});

Route::group(['middleware' => 'auth'], function($router) {
    $router->group(['prefix' => 'challenge'], function () use ($router) {
        $router->get('/', 'ChallengeController@index');

        $router->get('teams', 'ChallengeController@getTeams');
        $router->post('teams', 'ChallengeController@storeTeam');
        $router->post('teams/{id}', 'ChallengeController@updateTeam');

        $router->get('members', 'ChallengeController@getMembers');
        $router->get('members/categories', 'ChallengeController@getMembersCategories');

        $router->get('attendants', 'ChallengeController@getAttendants');
        $router->post('attendants', 'ChallengeController@storeAttendant');
        $router->post('attendants/{id}', 'ChallengeController@updateAttendant');
        $router->get('attendants/types', 'ChallengeController@getAttendantsTypes');
    });
});
