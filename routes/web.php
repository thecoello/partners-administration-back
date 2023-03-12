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

/* $router->get('/', function () use ($router) {
    return $router->app->version();
}); */

$router->post('/', ['middleware' => ['auth'], function (Request $request) use ($router) {

    $user = Auth::user();
    $user = $request->user();
    $request->session()->put('key', $user->id);
    $response = [
        'name' => $user->id,
        'id' => $user->id,
        'user_type' => $user->user_type,
        'token' => strval($request->cookie('lumen_session'))
    ];


    return response()->json($response,200);

}]);

$router->group(['prefix' => '/'], function () use ($router) {

    //USERS
    $router->get('/api/getusers',  ['uses' => 'UsersController@showAllUsers']);
    $router->get('/api/getuser/{id}', ['uses' => 'UsersController@showUser']);
    $router->get('/api/getusersinvoices', ['uses' => 'UsersController@showAllUsersInvoices']);
    $router->get('/api/getuserinvoice/{id}', ['uses' => 'UsersController@showUserInvoice']);
    $router->get('/',  ['uses' => 'UsersController@loginCheck']);
    $router->post('/logout',  ['uses' => 'UsersController@logOut']);

    $router->post('/api/postuser', ['uses' => 'UsersController@createUser']);
    $router->delete('/api/deleteuser/{id}', ['uses' => 'UsersController@deteleUser']);
    $router->put('/api/putuser/{id}', ['uses' => 'UsersController@updateUser']);

    //PACKGES
    $router->get('/api/getpackages',  ['uses' => 'PackagesController@showAllPackages']);
    $router->get('/api/getpackage/{id}',  ['uses' => 'PackagesController@showPackage']);
    $router->post('/api/postpackage',  ['uses' => 'PackagesController@createPackage']);
    $router->delete('/api/deletepackage',  ['uses' => 'PackagesController@detelePackage']);
    $router->put('/api/putpackage',  ['uses' => 'PackagesController@updatePackage']);

    //LOCATIONS
    $router->get('/api/getlocations',  ['uses' => 'LocationsController@showAllLocations']);
    $router->get('/api/getlocation/{id}',  ['uses' => 'LocationsController@showLocation']);
    $router->post('/api/postlocation',  ['uses' => 'LocationsController@createLocation']);
    $router->delete('/api/deletelocation',  ['uses' => 'LocationsController@deteleLocation']);
    $router->put('/api/putlocation',  ['uses' => 'LocationsController@updateLocation']);

    //INVOICES
    $router->get('/api/getinvoices',  ['uses' => 'InvoiceController@showAllInvoices']);
    $router->get('/api/getinvoice/{user_id}',  ['uses' => 'InvoiceController@showInvoice']);
    $router->post('/api/postinvoice',  ['uses' => 'InvoiceController@createInvoice']);
    $router->delete('/api/deleteinvoice/{user_id}',  ['uses' => 'InvoiceController@deteleInvoice']);
    $router->put('/api/putinvoice/{user_id}',  ['uses' => 'InvoiceController@updateInvoice']);
    $router->put('/api/putinvoicedetails/{user_id}',  ['uses' => 'InvoiceController@updateInvoiceDetails']);
    $router->put('/api/putpaymentsatus/{user_id}',  ['uses' => 'InvoiceController@updatePaymentStatus']);

    //EVENT INFO
    $router->get('/api/eventinfo',  ['uses' => 'EventController@showAllEvents']);
    $router->get('/api/puteventinfo/{id}',  ['uses' => 'EventController@updateEvent']);
});
