<?php

use Illuminate\Support\Facades\Route;
use Workdo\FoodBank\Http\Controllers\FoodBankController;
use Workdo\FoodBank\Http\Controllers\DonorController;
use Workdo\FoodBank\Http\Controllers\InventoryController;
use Workdo\FoodBank\Http\Controllers\DistributionController;
use Workdo\FoodBank\Http\Controllers\ReportController;
use Workdo\FoodBank\Http\Controllers\RequestController;

Route::middleware(['web', 'auth', 'verified'])->prefix('foodbank')->name('foodbank.')->group(function () {
    Route::get('dashboard', [FoodBankController::class, 'dashboard'])->name('dashboard');
    Route::resource('donors', DonorController::class)->except(['show']);
    Route::resource('inventory', InventoryController::class)->except(['show']);
    Route::resource('distributions', DistributionController::class)->only(['index', 'create', 'store']);
    Route::get('reports', [ReportController::class, 'index'])->name('reports');
    Route::resource('requests', RequestController::class);
    Route::get('requests/{request}/approve', [RequestController::class, 'approve'])->name('requests.approve');
    Route::get('requests/{request}/reject', [RequestController::class, 'reject'])->name('requests.reject');
});
