<?php

use Illuminate\Support\Facades\Route;
//controladores

use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;

use App\Http\Controllers\CuartelesController;
use App\Http\Controllers\MausoleosController;
use App\Http\Controllers\TumbasController;

use App\Exports\CuartelesExports;
use Maatwebsite\Excel\Facades\Excel;
 

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>['auth']],function () {
    Route::resource('roles', RolController::class);    
    Route::resource('usuarios', UsuarioController::class);    
    Route::resource('cuarteles', CuartelesController::class);    
    Route::resource('mausoleos', MausoleosController::class);    
    Route::resource('tumbas', TumbasController::class);    
});

Route::get('/exportarCuarteles', [App\Http\Controllers\CuartelesController::class, 'export'])->name('exportarCuarteles');
Route::get('/exportarMausoleos', [App\Http\Controllers\MausoleosController::class, 'export'])->name('exportarMausoleos');
Route::get('/exportarTumbas', [App\Http\Controllers\TumbasController::class, 'export'])->name('exportarTumbas');