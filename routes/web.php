<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Application;

Route::get('/', function () {
    return view('dashboard.welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])
    ->prefix('crm')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.index', [
                'auth' => [
                    'user'         => auth()->user(),
                    'isAdmin'      => auth()->user()->isAdmin ?? false,
                    'isSuperadmin' => auth()->user()->isSuperadmin ?? false,
                ],
            ]);
        })->name('dashboard');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Modularização das rotas
require __DIR__.'/auth.php';
require __DIR__.'/modules/users.php';
require __DIR__.'/modules/clients.php';
