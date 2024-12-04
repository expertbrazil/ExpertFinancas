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
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FaturaController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\TechnicalHelpController;

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
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Módulo de Cadastros
    Route::resource('clientes', ClienteController::class);
    Route::resource('servicos', ServicoController::class);
    Route::resource('produtos', ProdutoController::class);
    Route::resource('categorias', CategoriaController::class);

    // Módulo Financeiro
    Route::resource('contas-pagar', ContaPagarController::class);
    Route::resource('contas-receber', ContaReceberController::class);
    Route::resource('faturas', FaturaController::class);
    Route::resource('documentos', DocumentoController::class);
    Route::get('documentos/{documento}/download', [DocumentoController::class, 'download'])->name('documentos.download');
    
    // Gerenciamento de Funções
    Route::resource('roles', RoleController::class);
    
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

    // Módulo de Tickets
    Route::resource('tickets', TicketController::class);
    Route::patch('tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.status');

    // Configurações do Sistema
    Route::get('/parametros', [ParametroController::class, 'edit'])->name('parametros.edit');
    Route::put('/parametros', [ParametroController::class, 'update'])->name('parametros.update');

    // Exportação de Relatórios
    Route::get('/relatorios/financeiro', [RelatorioController::class, 'financeiro'])->name('relatorios.financeiro');
    Route::get('/relatorios/clientes', [RelatorioController::class, 'clientes'])->name('relatorios.clientes');
    Route::get('/relatorios/servicos', [RelatorioController::class, 'servicos'])->name('relatorios.servicos');
    Route::get('/relatorios/produtos', [RelatorioController::class, 'produtos'])->name('relatorios.produtos');

    // Rotas para Tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/responder', [TicketController::class, 'responder'])->name('tickets.responder');
    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.update-status');

    // Rotas do Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas Financeiro
    Route::middleware(['auth', 'role:admin'])->prefix('financeiro')->name('financeiro.')->group(function () {
        Route::get('/receitas', [FinanceiroController::class, 'receitas'])->name('receitas');
        Route::get('/despesas', [FinanceiroController::class, 'despesas'])->name('despesas');
        Route::get('/fluxo-caixa', [FinanceiroController::class, 'fluxoCaixa'])->name('fluxo-caixa');
        Route::get('/conciliacao', [FinanceiroController::class, 'conciliacao'])->name('conciliacao');
    });

    // Rotas Relatórios
    Route::middleware(['auth', 'role:admin'])->prefix('relatorios')->name('relatorios.')->group(function () {
        Route::get('/clientes', [RelatoriosController::class, 'clientes'])->name('clientes');
        Route::get('/faturas', [RelatoriosController::class, 'faturas'])->name('faturas');
        Route::get('/tickets', [RelatoriosController::class, 'tickets'])->name('tickets');
        Route::get('/financeiro', [RelatoriosController::class, 'financeiro'])->name('financeiro');
    });

    // Rotas Configurações
    Route::middleware(['auth', 'role:admin'])->prefix('configuracoes')->name('configuracoes.')->group(function () {
        Route::get('/empresa', [ConfiguracoesController::class, 'empresa'])->name('empresa');
        Route::get('/usuarios', [ConfiguracoesController::class, 'usuarios'])->name('usuarios');
        Route::get('/permissoes', [ConfiguracoesController::class, 'permissoes'])->name('permissoes');
        Route::get('/notificacoes', [ConfiguracoesController::class, 'notificacoes'])->name('notificacoes');
        Route::get('/integracao', [ConfiguracoesController::class, 'integracao'])->name('integracao');
        Route::get('/backup', [ConfiguracoesController::class, 'backup'])->name('backup');
        Route::get('/logs', [ConfiguracoesController::class, 'logs'])->name('logs');
    });

    // Rotas de Ajuda Técnica
    Route::middleware(['auth'])->group(function () {
        Route::get('/technical-help', [TechnicalHelpController::class, 'index'])->name('technical-help.index');
        Route::get('/technical-help/search', [TechnicalHelpController::class, 'search'])->name('technical-help.search');
        Route::get('/technical-help/diagram', [TechnicalHelpController::class, 'diagram'])->name('technical-help.diagram');
        Route::get('/technical-help/{topic}', [TechnicalHelpController::class, 'show'])->name('technical-help.show');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
