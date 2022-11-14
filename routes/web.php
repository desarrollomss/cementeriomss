<?php

use Illuminate\Support\Facades\Route;
//controladores

use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TumbasController;
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
    Route::get('/cementerio/registros/tumbas', [TumbasController::class, 'index'])->name('tumbas.index');
    Route::get('obtenertumbas', [TumbasController::class, 'obtenertumbas'])->name('obtener.tumbas');
    Route::get('/cementerio/registros/crear',[TumbasController::class, 'create'])->name('tumbas.create');
    Route::get('detalletumbas',[TumbasController::class, 'detalletumbas'])->name('detalle.tumbas');
});
