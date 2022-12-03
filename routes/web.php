<?php

use Illuminate\Support\Facades\Route;
//controladores

use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TumbasController;

use App\Http\Controllers\MausoleosController;
use App\Http\Controllers\ReportesController;

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
    return view('auth.login');
});

Route::get('/register', function(){
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>['auth']],function () {
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);

    // Rutas para MODULO TUMBAS
    Route::get('/cementerio/registros/tumbas', [TumbasController::class, 'index'])->name('tumbas.index');
    Route::get('obtenertumbas', [TumbasController::class, 'obtenertumbas'])->name('obtener.tumbas');
    Route::get('/cementerio/registros/crear/tumbas',[TumbasController::class, 'create'])->name('tumbas.create');
    Route::post('/cementerio/registros/crear/tumbas',[TumbasController::class,'store'])->name('tumbas.store');
    Route::get('detalletumbas',[TumbasController::class, 'detalletumbas'])->name('detalle.tumbas');
    Route::get('/cementerio/registros/{id}/edit/tumbas',[TumbasController::class, 'edit'])->name('tumbas.edit');
    Route::put('/cementerio/registros/{id}/update/tumbas',[TumbasController::class, 'update'])->name('tumbas.update');
    Route::get('detalleeliminar',[TumbasController::class, 'detalleeliminar'])->name('detalle.eliminar');
    Route::post('/cementerio/registros/delete/tumbas',[TumbasController::class, 'delete'])->name('tumbas.delete');

    // Rutas para MODULO TUMBAS
    Route::get('/cementerio/registros/mausoleos', [MausoleosController::class, 'index'])->name('mausoleos.index');
    Route::get('obtenermausoleos', [MausoleosController::class, 'obtenermausoleos'])->name('obtener.mausoleos');
    Route::get('/cementerio/registros/crear/mausoleos',[MausoleosController::class, 'create'])->name('mausoleos.create');
    Route::post('/cementerio/registros/crear/mausoleos',[MausoleosController::class,'store'])->name('mausoleos.store');
    Route::get('detallemausoleos',[MausoleosController::class, 'detallemausoleos'])->name('detalle.mausoleos');



    //RUTAS para REPORTES
    Route::get('/cementerio/reportes',[ReportesController::class, 'index'])->name('reportes.general');
    Route::post('/cementerio/export/general', [ReportesController::class, 'registrosexportar'])->name('registros.export');
    Route::post('/consultaobs',[ReportesController::class,'consultaobservaciones'])->name('consulta');
    Route::get('/cementerio/export/{id}/filtro', [ReportesController::class, 'registrosexportarconsulta'])->name('registros.consulta.export');
    Route::post('/cementerio/export/anio', [ReportesController::class, 'registrosporanio'])->name('registrosporanio.export');
});

