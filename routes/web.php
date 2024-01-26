<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CircleController;
use App\Http\Controllers\RangeController;
use App\Http\Controllers\TechnicalController;
use App\Http\Controllers\CommissionerController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ArrearController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


// Circle group routes
Route::middleware(['auth', 'role:circle'])->name('circle.')->group(function () {
    
    Route::get('/circle-dashboard', [CircleController::class, 'index'])->name('dashboard');

    Route::get('/stock', [StockController::class, 'index'])->name('stock');

    Route::get('/arrear', [ArrearController::class, 'index'])->name('arrear.index');
    
});



Route::middleware(['auth', 'role:range'])->group(function () {
    Route::get('/range-dashboard', [RangeController::class, 'index']);
});


Route::middleware(['auth', 'role:technical'])->group(function () {
    Route::get('/technical-dashboard', [TechnicalController::class, 'index']);
});

Route::middleware(['auth', 'role:commissioner'])->group(function () {
    Route::get('/commissioner-dashboard', [CommissionerController::class, 'index']);
});
