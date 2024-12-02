<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/tickets/count', function () {
        return response()->json([
            'count' => \App\Models\Ticket::where('status', 'aberto')->count()
        ]);
    })->name('api.tickets.count');

    // API Endpoints para Tickets
    Route::prefix('tickets')->group(function () {
        Route::get('/', [TicketController::class, 'apiIndex']);
        Route::post('/', [TicketController::class, 'apiStore']);
        Route::get('/{ticket}', [TicketController::class, 'apiShow']);
        Route::post('/{ticket}/responder', [TicketController::class, 'apiResponder']);
        Route::patch('/{ticket}/status', [TicketController::class, 'apiUpdateStatus']);
    });
});
