<?php

use Illuminate\Support\Facades\Route;
use App\Models\Libro;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



// se puso ento en las rutas para poder probar los scopes, se accede con http://localhost:8080/biblioteca/public/test-scopes
// configure el puerto de mi xampp para usar el 8080 porque el 80 me generaba problemas


Route::get('/test-scopes', function () {
    $disponibles = Libro::disponibles()->pluck('titulo');
    $publicados2020 = Libro::publicadoEn(2020)->pluck('titulo');
    $porAutorTexto = Libro::deAutor('García')->pluck('titulo');

    return compact('disponibles', 'publicados2020', 'porAutorTexto');
});
