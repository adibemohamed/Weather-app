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


Route::get('/weather', function () {
    $apiKey = config('services.weatherbit.key');
    $lat = request('lat');
    $lng = request('lng');
    $response = Zttp::get("https://api.weatherbit.io/v2.0/current?lat=$lat&lon=$lng&key=$apiKey");
    return $response;
});
