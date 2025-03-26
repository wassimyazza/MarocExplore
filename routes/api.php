<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\DestinationController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/itineraries', [ItineraryController::class, 'store']);
    Route::get('/itineraries', [ItineraryController::class, 'index']);
    Route::get('/itineraries/{id}', [ItineraryController::class, 'show'])->where('id', '[0-9]+');
    Route::put('/itineraries/{id}', [ItineraryController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('/itineraries/{id}', [ItineraryController::class, 'destroy'])->where('id', '[0-9]+');

    Route::post('/itineraries/{id}/destinations', [DestinationController::class, 'store'])->where('id', '[0-9]+');
    Route::get('/itineraries/{id}/destinations', [DestinationController::class, 'index'])->where('id', '[0-9]+');

    Route::get('/itineraries/search', [ItineraryController::class, 'search']);
    
    Route::get('/itineraries/watchlist', [ItineraryController::class, 'getWatchlist']);
    Route::post('/itineraries/watchlist/{id}', [ItineraryController::class, 'addWatchlist']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
