<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    // Rota para listar os clientes
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');

    // Rota para criar um novo cliente
    Route::get('/clients/create', [ClientController::class, 'createClient'])->name('clients.create');

    // Rota para exibir um cliente específico
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
});
