<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('crm')->middleware(['auth'])->group(function () {
    // Listagem e visualização de usuários
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    // Criação de usuários (normal)
    Route::middleware(['can:create,user'])->group(function () {
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
    });

    // Edição de usuários
    Route::middleware(['can:update,user'])->group(function () {
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    });

    // Criação de Administradores do Setor (Team Admin)
    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('/users/team-admin/create', [UserController::class, 'createTeamAdmin'])
            ->name('users.teamadmin.create');
        Route::post('/users/team-admin', [UserController::class, 'storeTeamAdmin'])
            ->name('users.teamadmin.store');
    });

    // Exclusão de usuários
    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy')
        ->middleware('can:delete,user');

    // Exibição de usuários do setor (Team Admin)
    Route::get('/users/team', [UserController::class, 'team'])->name('users.team');
});
