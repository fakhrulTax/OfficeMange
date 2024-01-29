<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CircleController;
use App\Http\Controllers\RangeController;
use App\Http\Controllers\TechnicalController;
use App\Http\Controllers\CommissionerController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ArrearController;
use App\Http\Controllers\CollectionController;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


// Circle group routes
Route::middleware(['auth', 'role:circle'])->name('circle.')->group(function () {
    
    Route::get('/circle-dashboard', [CircleController::class, 'index'])->name('dashboard');

    Route::get('/stock', [StockController::class, 'index'])->name('stock');
    Route::post('/stock', [StockController::class, 'store'])->name('stockStore');

    Route::get('/stock/edit', [StockController::class, 'edit'])->name('stockEdit');
    Route::post('/stock/edit', [StockController::class, 'update'])->name('stockUpdate');

    //Collection Route
    Route::get('/collection', [CollectionController::class, 'index'])->name('collection.index');
    Route::get('/collection/create', [CollectionController::class, 'create'])->name('collection.create');
    Route::post('/collection/store', [CollectionController::class, 'store'])->name('collection.store');
    Route::get('/collection/{id}/edit', [CollectionController::class, 'edit'])->name('collection.edit');
	Route::put('/collection/{id}', [CollectionController::class, 'update'])->name('collection.update');
	Route::get('/collection/search', [CollectionController::class, 'search'])->name('collection.search');


    //Tin checker

    Route::get('/tin-checker/{tin}', [StockController::class, 'tinChecker'])->name('tinChecker');


    //Arrear routes
    Route::get('/arrears', [ArrearController::class, 'index'])->name('arrears');
    Route::post('/arrear', [ArrearController::class, 'store'])->name('arrearStore');
    Route::get('/arrear/edit', [ArrearController::class, 'edit'])->name('arrearEdit');
    Route::post('/arrear/edit', [ArrearController::class, 'update'])->name('arrearUpdate');
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
 