<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//En esta sección se hará la ruta para consumir el servicio
//se manda llamar el controlador
use App\Http\Controllers\AutControllerh;//"AuthControllerh" es el nombre del controlador
use App\Http\Controllers\usersController;//"usersController"llama a los controladores usersController
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
//se genera la ruta
Route::controller(AutControllerh::Class)->group(function(){
    //De acuerdo a la acción que se pretenda hacer en el controlador se define el método, si es post o get. 
    Route::post('/register','register');
    // El nombre de la ruta es  /register
    // El nombre de la función es register
    //Se va a trabajar de manera local
    Route::post('/login','login');
    Route::post('/logout','logout');
});

Route::middleware('auth:sanctum')->delete('/logout', [AutControllerh::class, 'logout']);
Route::get('/users/show/{id}', [usersController::class,'showById']);


