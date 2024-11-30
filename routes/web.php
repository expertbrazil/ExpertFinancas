<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ContaPagarController;
use App\Http\Controllers\ContaReceberController;
use App\Http\Controllers\PlanoHospedagemController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ParametroController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRegistrationController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\HostingPlanController;

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
    // Rota principal redireciona para o dashboard
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Módulo de Cadastros
    Route::resource('clientes', ClienteController::class);
    Route::resource('servicos', ServicoController::class);
    Route::resource('produtos', ProdutoController::class);
    Route::resource('categorias', CategoriaController::class);

    // Módulo Financeiro
    Route::resource('contas-pagar', ContaPagarController::class);
    Route::resource('contas-receber', ContaReceberController::class);
    
    // Status de Contas
    Route::patch('contas-pagar/{conta}/status', [ContaPagarController::class, 'updateStatus'])->name('contas-pagar.status');
    Route::patch('contas-receber/{conta}/status', [ContaReceberController::class, 'updateStatus'])->name('contas-receber.status');

    // Planos de Hospedagem
    Route::resource('planos', HostingPlanController::class);
    Route::patch('planos/{plano}/toggle-status', [HostingPlanController::class, 'toggleStatus'])
        ->name('planos.toggle-status');

    // Gerenciamento de Usuários
    Route::get('/users/create', [UserRegistrationController::class, 'create'])->name('users.create');
    Route::post('/users', [UserRegistrationController::class, 'store'])->name('users.store');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Rotas para alteração de senha
    Route::get('/users/{user}/password', [PasswordController::class, 'edit'])->name('users.password.edit');
    Route::put('/users/{user}/password', [PasswordController::class, 'update'])->name('users.password.update');

    // Subcategorias (AJAX)
    Route::get('/categorias/{categoria}/subcategorias', [CategoriaController::class, 'getSubcategorias'])
        ->name('categorias.subcategorias');

    // Validação de CPF/CNPJ
    Route::get('/validacao-cpf', function () {
        return view('validacao-cpf');
    });

    // Configurações do Sistema
    Route::get('/parametros', [ParametroController::class, 'edit'])->name('parametros.edit');
    Route::put('/parametros', [ParametroController::class, 'update'])->name('parametros.update');

    // Exportação de Relatórios
    Route::get('/relatorios/financeiro', [RelatorioController::class, 'financeiro'])->name('relatorios.financeiro');
    Route::get('/relatorios/clientes', [RelatorioController::class, 'clientes'])->name('relatorios.clientes');
    Route::get('/relatorios/servicos', [RelatorioController::class, 'servicos'])->name('relatorios.servicos');
    Route::get('/relatorios/produtos', [RelatorioController::class, 'produtos'])->name('relatorios.produtos');
});
