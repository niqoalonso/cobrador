<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GestionRolController;
use App\Http\Controllers\WebMasterController;
use App\Http\Controllers\RepresentanteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\AreaLocalController;
use App\Http\Controllers\ArriendoController;
use App\Http\Controllers\AbonoController;
use App\Http\Controllers\PosturaController;
use App\Http\Controllers\RendicionAbonoController;
use App\Http\Controllers\RendicionPosturaController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/login');

Route::resource('/administracion', WebMasterController::class);

//Gestion Usuario
Route::resource('GestionUser', UserController::class)->middleware('can:Gestion Usuarios');
Route::get('GestionUser/{rut}/verificar', [UserController::class, 'verificarUser'])->middleware('can:Gestion Usuarios');

//Gestion Permisos & Roles
Route::resource('gestion-rol-permision', GestionRolController::class)->middleware('can:Gestion Roles & Permisos');
Route::get('/verificarUsoRol/{id}', [GestionRolController::class, 'verificarUsoROl'])->middleware('can:Gestion Roles & Permisos');

//Gestion Representante
Route::resource('/gestionRepresentante', RepresentanteController::class)->middleware('can:Gestion Representante');
Route::get('gestionRepresentante/{rut}/verificar', [RepresentanteController::class, 'verificarRepresentante'])->middleware('can:Gestion Representante');
Route::get('verificarUsoRepresentante/{id}', [RepresentanteController::class, 'verificarUsoRepresentante'])->middleware('can:Gestion Representante');

//Gestion Cliente / Empresa

Route::resource('gestionEmpresas', EmpresaController::class)->middleware('can:Gestion Clientes');
Route::get('gestionEmpresas/{rut}/verificar', [EmpresaController::class, 'verificarEmpresa'])->middleware('can:Gestion Clientes');
Route::get('/ListCliente', [EmpresaController::class, 'getListCliente'])->name('getLlistEmpresa')->middleware('can:Gestion Clientes');
Route::get('/redireccionarListadoArriendo', [EmpresaController::class, 'redireccionarArriendo'])->middleware('can:Gestion Clientes');

//Gestion Arriendos

Route::resource('gestionArriendo', ArriendoController::class)->middleware('can:Gestion Arriendo');
Route::get('/gestionArriendoOnly/{id}', [ArriendoController::class, 'gestionArriendoOnly'])->middleware('can:Gestion Arriendo');



//Gestion Area y Local 
Route::get('/gestionLocales', [AreaLocalController::class, 'index'])->name('gestionLocales.index');
Route::get('/getLocalesDisponibles', [AreaLocalController::class, 'getLocalDisponible']);

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
Route::get('/verificarUsoLocal/{id}', [AreaLocalController::class, 'verificarUsoLocal']);
Route::delete('/eliminarLocal/{id}', [AreaLocalController::class, 'eliminarLocal']);
Route::get('getLocalDisponible', [AreaLocalController::class, 'getLocalDisponible']);


//Gestión Abonos

Route::resource('gestionAbono', AbonoController::class);
Route::get('/getFacturacionPagoPendiente/{sku}', [AbonoController::class, 'getFacturacionPagoPendiente']);
Route::get('/getAbonoFactura/{id}', [AbonoController::class, 'getAbonoFactura']);
Route::get('historialAbonos', [AbonoController::class, 'historialAbono'])->name('historial.abono');
Route::get('getFacturasHistorial/{sku}', [AbonoController::class, 'getHistorialAbono']);
Route::get('getLocalesArriendo/{sku}', [AbonoController::class, 'getLocalArriendo']);
Route::get('getArriendosAbonos/{sku}', [AbonoController::class, 'getArriendos']);
Route::get('getFacturaDeArriendo/{sku}/{fecha}', [AbonoController::class, 'getFacturaDeArriendo']);
Route::get('getDetalleAbono/{sku}', [AbonoController::class, 'getDetalleAbono']);
Route::post('anularAbono', [AbonoController::class, 'anularAbono']);
Route::get('anulacionAbonos', [AbonoController::class, 'anulacionAbonos'])->name('anulacion.abonos');
Route::post('aceptarAnulacionAbono', [AbonoController::class, 'aceptarAnulacionAbono']);
Route::get('verMotivoAnulacionAbono/{id}', [AbonoController::class, 'verMotivoAnulacionAbono']);


//Gestión Posturas

Route::resource('gestionPostura', PosturaController::class);
Route::get('getArriendosPosturas/{sku}', [PosturaController::class, 'getArriendos']);
Route::get('getItemPostura/{id}', [PosturaController::class, 'getItemPostura']);
Route::get('getPosturasArriendo/{sku}', [PosturaController::class, 'getPosturaArriendo']);
Route::get('getDetallePostura/{sku}', [PosturaController::class, 'getDetallePostura']);
Route::post('anularPostura', [PosturaController::class, 'anularPostura']);
Route::get('historialPosturas', [PosturaController::class, 'historialPostura'])->name('historial.postura');
Route::post('searchPostura', [PosturaController::class, 'searchPostura']);
Route::get('anulacionPosturas', [PosturaController::class, 'anulacionPostura'])->name('anulacion.postura');
Route::post('aceptarAnulacionPostura', [PosturaController::class, 'aceptarAnulacionPostura']);
Route::get('verMotivoAnulacionPostura/{id}', [PosturaController::class, 'verMotivoAnulacionPostura']);

//GestionRendicion

Route::get('gestionarRendicionA', [RendicionAbonoController::class, 'indexAbono'])->name('gestionRendicionAbono.index');
Route::get('storeRendicionAbono', [RendicionAbonoController::class, 'storeRendicionAbono']);
Route::get('historialRendicionAbono', [RendicionAbonoController::class, 'indexHistorial'])->name('indexHistorial.abono');
Route::get('getHistorialRendicionAbono/{fecha}', [RendicionAbonoController::class, 'getHistorialAbono']);
Route::get('getAbonosRendicion/{id}', [RendicionAbonoController::class, 'getAbonoRendicion']);
Route::get('solicitudRendicionAbonos', [RendicionAbonoController::class, 'indexSolicitudRendicion'])->name('indexSolicitud.abono');
Route::get('aprobarRendicionAbonos/{id}', [RendicionAbonoController::class, 'aprobarRendicionAbonos']);

Route::get('gestionarRendicionP', [RendicionPosturaController::class, 'indexPostura'])->name('gestionRendicionPostura.index');
Route::get('storeRendicionPostura', [RendicionPosturaController::class, 'storeRendicionPostura']);
Route::get('historialRendicionPostura', [RendicionPosturaController::class, 'indexHistorial'])->name('indexHistorial.postura');
Route::get('getHistorialRendicionPostura/{fecha}', [RendicionPosturaController::class, 'getHistorialPostura']);
Route::get('getPosturasRendicion/{id}', [RendicionPosturaController::class, 'getPosturaRendicion']);
Route::get('solicitudRendicionPosturas', [RendicionPosturaController::class, 'indexSolicitudRendicion'])->name('indexSolicitud.postura');
Route::get('aprobarRendicionPosturas/{id}', [RendicionPosturaController::class, 'aprobarRendicionPosturas']);


//DOM PDF

Route::get('verpdfdescargar', [WebMasterController::class, 'domPDFDescargar']); // Descarga

Route::get('verpdfnavegador', [WebMasterController::class, 'domPDFNavegador']); // Ver Navegador

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
