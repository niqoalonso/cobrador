<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GestionRolController;
use App\Http\Controllers\WebMasterController;

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

Route::resource('/administracion', WebMasterController::class);

Route::resource('GestionUser', UserController::class);
Route::get('GestionUser/{rut}/verificar', [UserController::class, 'verificarUser']);

Route::resource('gestion-rol-permision', GestionRolController::class);
Route::get('/verificarUsoRol/{id}', [GestionRolController::class, 'verificarUsoROl']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
