<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

$router->group(['prefix' => '/'], function () use ($router) {

    //USERS
    $router->get('/api/users',  ['uses' => 'UsersController@getUsers']);
    $router->get('/api/users/{id}', ['uses' => 'UsersController@getUser']);
    $router->post('/api/users', ['uses' => 'UsersController@postUser']);
    $router->put('/api/users/{id}', ['uses' => 'UsersController@updateUser']);
    $router->delete('/api/users/{id}', ['uses' => 'UsersController@deteleUser']);

    //PACKGES
    $router->get('/api/packages',  ['uses' => 'PackagesController@getPackages']);
    $router->post('/api/packages',  ['uses' => 'PackagesController@postPackages']);
    $router->put('/api/packages/{id}',  ['uses' => 'PackagesController@updatePackages']);
    $router->delete('/api/packages/{id}',  ['uses' => 'PackagesController@deletePackages']);

    //LOCATIONS
    $router->get('/api/locations',  ['uses' => 'LocationsController@getLocations']);
    $router->post('/api/locations',  ['uses' => 'LocationsController@postLocations']);
    $router->put('/api/locations/{id}',  ['uses' => 'LocationsController@updateLocations']);
    $router->delete('/api/locations/{id}',  ['uses' => 'LocationsController@deleteLocations']);

    //INVOICES
    $router->get('/api/invoices/',  ['uses' => 'InvoiceController@getInvoices']);
    $router->get('/api/invoices/search/{search}',  ['uses' => 'InvoiceController@getInvoicesSearch']);
    $router->get('/api/invoices/{id}',  ['uses' => 'InvoiceController@getInvoice']);
    $router->post('/api/invoices',  ['uses' => 'InvoiceController@postInvoice']);
    $router->put('/api/invoices/{id}',  ['uses' => 'InvoiceController@putInvoices']);
    $router->put('/api/invoices/user/{id}',  ['uses' => 'InvoiceController@putInvoicesUser']);
    $router->delete('/api/invoices/{id}',  ['uses' => 'InvoiceController@deleteInvoices']);

    //EVENT INFO
    $router->get('/api/eventinfo',  ['uses' => 'EventController@showAllEvents']);
    $router->get('/api/puteventinfo/{id}',  ['uses' => 'EventController@updateEvent']);
});