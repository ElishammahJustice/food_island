<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\RestaurantController;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//routes
Route::post('/location',  [LocationController::class, 'createLocation']);
Route::get('/location',  [LocationController::class, 'index']);
Route:: get ('/location/{id} ',  [LocationController::class, 'index']);
Route:: put ('/location/{id}',  [LocationController::class, 'index']);
Route:: delete('/location/{id}',  [LocationController::class, 'deleteLocation']);
Route:: get ('/location/{search} ',  [LocationController::class, 'index']);
//restaurant routes
Route::post('/restaurant',  [RestaurantController::class, 'createRestaurant']);
Route::get('/restaurant/{id}',  [RestaurantController::class, 'getRestaurant']);
Route::get('/restaurant',  [RestaurantController::class, 'index']);
Route:: delete('/restaurant/{id}',  [LocationController::class, 'deleteRestaurant']);
