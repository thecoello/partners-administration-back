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
    $router->get('getusers',  ['uses' => 'UsersController@showAllUsers']);
    $router->get('getuser/{id}', ['uses' => 'UsersController@showUser']);
    $router->post('postuser', ['uses' => 'UsersController@createUser']);
    $router->delete('deleteuser/{id}', ['uses' => 'UsersController@deteleUser']);
    $router->put('putuser/{id}', ['uses' => 'UsersController@updateUser']);

    //PACKGES
    $router->get('getpackages',  ['uses' => 'PackagesController@showAllPackages']);
    $router->get('getpackage',  ['uses' => 'PackagesController@showPackage']);
    $router->post('postpackage',  ['uses' => 'PackagesController@createPackage']);
    $router->delete('deletepackage',  ['uses' => 'PackagesController@detelePackage']);
    $router->put('putpackage',  ['uses' => 'PackagesController@updatePackage']);

    //LOCATIONS
    $router->get('getlocations',  ['uses' => 'LocationsController@showAllLocations']);
    $router->get('getlocation',  ['uses' => 'LocationsController@showLocation']);
    $router->post('postlocation',  ['uses' => 'LocationsController@createLocation']);
    $router->delete('deletelocation',  ['uses' => 'LocationsController@deteleLocation']);
    $router->put('putlocation',  ['uses' => 'LocationsController@updateLocation']);

    //INVOICES
    $router->get('getinvoices',  ['uses' => 'InvoiceController@showAllInvoices']);
    $router->get('getinvoice/{user_id}',  ['uses' => 'InvoiceController@showInvoice']);
    $router->post('postinvoice',  ['uses' => 'InvoiceController@createInvoice']);
    $router->delete('deleteinvoice',  ['uses' => 'InvoiceController@deteleInvoice']);
    $router->put('putinvoice/{user_id}',  ['uses' => 'InvoiceController@updateInvoice']);

});
