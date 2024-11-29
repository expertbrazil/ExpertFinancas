<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ParametroController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('clientes.index');
    });

    Route::resource('clientes', ClienteController::class);

    Route::get('/validacao-cpf', function () {
        return view('validacao-cpf');
    });

    // Rotas de Parametrização
    Route::get('/parametros', [ParametroController::class, 'edit'])->name('parametros.edit');
    Route::put('/parametros', [ParametroController::class, 'update'])->name('parametros.update');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
