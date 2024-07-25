<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GifController;

//Esta ruta es para avisar al usuario que no esta autenticado y pretende utilizar una ruta protegida
Route::get('/unauthorized', [AuthController::class, 'unauthorized'])->name('login');

Route::group(['prefix' => 'auth'], function() {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
    // La siguiente ruta requiere que el usuario tenga un token válido
    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'getUser']);
    });
});
// Las siguientes rutas requieren que el usuario tenga un token válido

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('search', [GifController::class, 'search']);
    Route::get('get', [GifController::class, 'get']);
    Route::post('save-fav', [GifController::class, 'saveFav']);
    Route::get('user-favs', [GifController::class, 'getUserFavorites']);
});

