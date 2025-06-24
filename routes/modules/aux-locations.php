<?php

use App\Http\Controllers\Admin\AuxLocationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','can:manage-aux-data'])
     ->prefix('admin/aux-locations')
     ->name('admin.aux-locations.')
     ->group(function() {
         Route::get('/',                     [AuxLocationController::class,'index'])->name('index');
         Route::get('/create/{type}',        [AuxLocationController::class,'create'])->name('create');
         Route::post('/store/{type}',        [AuxLocationController::class,'store'])->name('store');
         Route::get('/{location}/edit',      [AuxLocationController::class,'edit'])->name('edit');
         Route::put('/{location}/update',    [AuxLocationController::class,'update'])->name('update');
         Route::delete('/{location}/destroy',[AuxLocationController::class,'destroy'])->name('destroy');
     });
