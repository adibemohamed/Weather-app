<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Zttp\Zttp;

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


Route::get('/weather', function ($id) {
    $apiKey = config('services.weatherbit.key')
    $response = Zttp::get('https://api.weatherbit.io/v2.0/current?city=Raleigh,NC&key=$apiKey');
    return $response->json();
});
