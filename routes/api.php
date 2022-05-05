<?php

use App\Http\Controllers\FamiliaCotroller;
use App\Http\Controllers\UserController;
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


Route::group(['middleware'=>'auth:api'], function(){
    Route::get('user',[UserController::class,'user']);
    Route::post('logout',[UserController::class,'logout']);
});

//rutas de login
Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);

//Route::post('profile',[UserController::class,'profile'])->middleware('auth:api');

//rutas de familia
Route::get('familias',[FamiliaCotroller::class,'index']);
Route::get('listar_articulos/{url_familia}',[FamiliaCotroller::class,'listar_articulos']);
Route::get('familia/{url_familia}',[FamiliaCotroller::class,'familia']);
