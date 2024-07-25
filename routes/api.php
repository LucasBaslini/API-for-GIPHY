<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//Esta ruta es para avisar al usuario que no esta autenticado y pretende utilizar una ruta protegida
Route::get('/unauthorized', [AuthController::class, 'unauthorized'])->name('login');

Route::group(['prefix' => 'auth'], function() {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
    // La siguiente ruta requiere que el usuario tenga un token válido
    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('user', [AuthController::class, 'user']);
    });
});
// Las siguientes rutas requieren que el usuario tenga un token válido

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('search', [AuthController::class, 'logout']);
    Route::post('get/{id}', [AuthController::class, 'logout']);
    Route::post('save', [AuthController::class, 'logout']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('logout', [AuthController::class, 'logout']);

});

