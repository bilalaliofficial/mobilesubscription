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

Route::post('login', 'API\LoginController@index');
Route::post('register','API\RegisterController@index');

Route::middleware('auth:sanctum')->group(function (){
    Route::post('purchase','API\SubscriptionController@index');
    Route::post('check_subscription','API\SubscriptionController@check_subscription');
});
