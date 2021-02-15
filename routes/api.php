<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/vehicles', 'HomeController@getAllVehicles');
Route::get('/vehicles/{id_vehicle}', 'HomeController@getVehicle');

Route::get('/sedes', 'HomeController@getAllSedes');
Route::get('/sedes/{id_sede}', 'HomeController@getSede');

Route::get('/services', 'HomeController@getAllServices');
Route::get('/services/{id_service}', 'HomeController@getService');

Route::get('/reservations', 'HomeController@getAllReservations');
Route::get('/reservations/{id_reservation}', 'HomeController@getReservation');
Route::post('/reservations', 'HomeController@storeReservation');
