<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RestaurantController;
use App\Models\Restaurant;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']); // Add login route
//routes

Route::post('/location',  [LocationController::class, 'createLocation']);
Route::get('/location',  [LocationController::class, 'index']);
Route:: get ('/location/{id} ',  [LocationController::class, 'index']);
Route:: put ('/location/{id}',  [LocationController::class, 'index']);
Route:: delete('/location/{id}',  [LocationController::class, 'deleteLocation']);
Route:: get ('/location/{search} ',  [LocationController::class, 'index']);

//protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

//restaurant routes
Route::post('/restaurant',  [RestaurantController::class, 'createRestaurant']);
Route::get('/restaurant/{id}',  [RestaurantController::class, 'getRestaurant']);
Route::get('/restaurant',  [RestaurantController::class, 'index']);
Route:: delete('/restaurant/{id}',  [LocationController::class, 'deleteRestaurant']);
Route::put('/restaurant/{id}', [RestaurantController::class, 'updateRestaurant']);

  // Route::apiResource('users', UserController::class);
  Route::get('user', [UserController::class, 'index']);
  Route::post('user', [UserController::class, 'store']);
  Route::get('user/{id}', [UserController::class, 'show']);
  Route::put('user/{id}', [UserController::class, 'update']);
  Route::delete('user/{id}', [UserController::class, 'destroy']);

}
);
