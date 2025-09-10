<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\LibroController;
use App\Http\Controllers\Api\PrestamoController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//esta ruta se creo para probar el token que se genera.

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user();
});

// este no esta proyegido 
Route::post('/register', [AuthController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    // Libros
    Route::get('/libros', [LibroController::class, 'index']);
    Route::get('/libros/{id}', [LibroController::class, 'show']);
    Route::post('/libros', [LibroController::class, 'store']);
    Route::put('/libros/{id}', [LibroController::class, 'update']);
    Route::delete('/libros/{id}', [LibroController::class, 'destroy']); 
    

    // Préstamos
    Route::get('/prestamos', [PrestamoController::class, 'index']);
    Route::post('/prestamos', [PrestamoController::class, 'store']); 
    Route::put('/prestamos/{id}/devolver', [PrestamoController::class, 'devolver']); 

    //usuario
      Route::get('/usuarios', [UsuarioController::class, 'index']);    
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show']); 
    Route::post('/usuarios', [UsuarioController::class, 'store']);    
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update']); 
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']); 
});
