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

$router->post('/api/login',  ['uses' => 'LoginController@postLogin']);


$router->group(['middleware' => 'auth'], function () use ($router) {

    //USERS
    $router->get('/api/users',  ['uses' => 'UsersController@getUsers']);
    $router->get('/api/users/search/{search}',  ['uses' => 'UsersController@getUserSearch']);
    $router->get('/api/users/{id}', ['uses' => 'UsersController@getUser']);
    $router->post('/api/users', ['uses' => 'UsersController@postUser']);
    $router->put('/api/users/{id}', ['uses' => 'UsersController@updateUser']);
    $router->delete('/api/users/{id}', ['uses' => 'UsersController@deteleUser']);
    $router->get('/api/authuser',  ['uses' => 'LoginController@getAuthUser']);

    
    //INVOICES
    $router->get('/api/invoices/',  ['uses' => 'InvoiceController@getInvoices']);
    $router->get('/api/invoices/excel',  ['uses' => 'InvoiceController@getInvoicesExcel']);
    $router->get('/api/invoices/search/{search}',  ['uses' => 'InvoiceController@getInvoicesSearch']);
    $router->get('/api/invoices/{id}',  ['uses' => 'InvoiceController@getInvoicesByUser']);
    $router->get('/api/invoice/{id}',  ['uses' => 'InvoiceController@getInvoice']);

    $router->post('/api/invoice',  ['uses' => 'InvoiceController@postInvoice']);
    $router->post('/api/invoice/{id}',  ['uses' => 'InvoiceController@putInvoices']);
    $router->post('/api/invoice/user/{id}',  ['uses' => 'InvoiceController@putInvoicesUser']);
    $router->delete('/api/invoices/{id}',  ['uses' => 'InvoiceController@deleteInvoices']);

    //PACKGES
    $router->get('/api/packages',  ['uses' => 'PackagesController@getPackages']);
    $router->put('/api/packages/{id}',  ['uses' => 'PackagesController@updatePackages']);

    //LOCATIONS
    $router->get('/api/locations',  ['uses' => 'LocationsController@getLocations']);
    $router->put('/api/locations/{id}',  ['uses' => 'LocationsController@updateLocations']);

    //EVENT INFO
    $router->get('/api/eventinfo',  ['uses' => 'EventController@showAllEvents']);
    $router->put('/api/eventinfo',  ['uses' => 'EventController@updateEvent']);

    //STAND INFORMATION
    $router->post('/api/standinformation',  ['uses' => 'StandInformationController@postStandInfo']);
    $router->get('/api/standsinformation/',  ['uses' => 'StandInformationController@getStandsInfo']);
    $router->get('/api/standinformation/{id}',  ['uses' => 'StandInformationController@getStandInfo']);
    $router->post('/api/standinformationput/{id}',  ['uses' => 'StandInformationController@putStandInfo']);
});


