<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GestionRolController;
use App\Http\Controllers\WebMasterController;
use App\Http\Controllers\RepresentanteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\AreaLocalController;

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

//Gestion Usuario
Route::resource('GestionUser', UserController::class);
Route::get('GestionUser/{rut}/verificar', [UserController::class, 'verificarUser']);

//Gestion Permisos & Roles
Route::resource('gestion-rol-permision', GestionRolController::class);
Route::get('/verificarUsoRol/{id}', [GestionRolController::class, 'verificarUsoROl']);

//Gestion Representante
Route::resource('/gestionRepresentante', RepresentanteController::class);
Route::get('gestionRepresentante/{rut}/verificar', [RepresentanteController::class, 'verificarRepresentante']);

//Gestion Cliente / Empresa

Route::resource('gestionEmpresas', EmpresaController::class);
Route::get('gestionEmpresas/{rut}/verificar', [EmpresaController::class, 'verificarEmpresa']);


//Gestion Area y Local 
Route::get('/gestionLocales', [AreaLocalController::class, 'index'])->name('gestionLocales.index');

//Gestión Area
Route::get('/gestionLocales/area', [AreaLocalController::class, 'getArea'])->name('gestionLocales.getArea');
Route::post('/crearArea', [AreaLocalController::class, 'storeArea']);
Route::get('/editarArea/{id}', [AreaLocalController::class, 'editarArea']);
Route::put('/updateArea/{id}', [AreaLocalController::class, 'updateArea']);
Route::get('/verificarUsoArea/{id}', [AreaLocalController::class, 'verificarUsoArea']);
Route::delete('/eliminarArea/{id}', [AreaLocalController::class, 'eliminarArea']);

//Gestión Local
Route::get('/gestionLocales/local', [AreaLocalController::class, 'getLocal'])->name('gestionLocales.getLocal');
Route::post('/crearLocal', [AreaLocalController::class, 'storeLocal']);
Route::get('/editarLocal/{id}', [AreaLocalController::class, 'editarLocal']);
Route::put('/updateLocal/{id}', [AreaLocalController::class, 'updateLocal']);



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
