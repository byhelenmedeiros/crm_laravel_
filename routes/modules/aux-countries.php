<?php

use App\Http\Controllers\Admin\AuxCountryController;
use App\Http\Controllers\Admin\AuxDataController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','can:manage-aux-data'])
     ->prefix('admin/aux-countries')
     ->name('admin.aux-countries.')
     ->group(function() {
            Route::get('/types', [AuxDataController::class, 'types'])
         ->name('types.index');
         Route::get('/',           [AuxCountryController::class,'index'])->name('index');
         Route::get('/create',     [AuxCountryController::class,'create'])->name('create');
         Route::post('/',          [AuxCountryController::class,'store'])->name('store');
         Route::get('/{aux_country}/edit', [AuxCountryController::class,'edit'])->name('edit');
         Route::put('/{aux_country}',      [AuxCountryController::class,'update'])->name('update');
         Route::delete('/{aux_country}',   [AuxCountryController::class,'destroy'])->name('destroy');
     });
