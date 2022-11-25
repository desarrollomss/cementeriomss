<?php

use Illuminate\Support\Facades\Route;
//controladores

use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TumbasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportesController;
use Faker\Guesser\Name;

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
    Route::get('/cementerio/registros/crear',[TumbasController::class, 'create'])->name('tumbas.create');
    Route::post('/cementerio/registros/crear',[TumbasController::class,'store'])->name('tumbas.store');
    Route::get('detalletumbas',[TumbasController::class, 'detalletumbas'])->name('detalle.tumbas');
    Route::get('/cementerio/registros/{id}/edit',[TumbasController::class, 'edit'])->name('tumbas.edit');
    Route::put('/cementerio/registros/{id}/update',[TumbasController::class, 'update'])->name('tumbas.update');
    Route::get('detalleeliminar',[TumbasController::class, 'detalleeliminar'])->name('detalle.eliminar');
    Route::post('/cementerio/registros/delete',[TumbasController::class, 'delete'])->name('tumbas.delete');

    //RUTAS para REPORTES
    Route::get('/cementerio/reportes',[ReportesController::class, 'index'])->name('reportes.general');
    Route::post('/cementerio/export/tumbas', [ReportesController::class, 'registrosexportar'])->name('registros.export');
    Route::post('/consultaobs',[ReportesController::class,'consultaobservaciones'])->name('consulta');
});

