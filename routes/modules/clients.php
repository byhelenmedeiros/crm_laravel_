<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.createClient'); 
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store'); // cria no banco
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
});
