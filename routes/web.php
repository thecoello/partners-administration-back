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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    //USERS
    $router->get('getusers',  ['uses' => 'UsersControllers@showAllUsers']);
    $router->get('getuser/{id}', ['uses' => 'UsersControllers@showUser']);
    $router->post('postuser', ['uses' => 'UsersControllers@createUser']);
    $router->delete('deleteuser/{id}', ['uses' => 'UsersControllers@deteleUser']);
    $router->put('putuser/{id}', ['uses' => 'UsersControllers@updateUser']);

  });