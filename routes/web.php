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
use App\Http\Controllers\OTPController;



use App\Http\Controllers\AppealController;



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

    //Appeal Route
    Route::get('/appeal', [AppealController::class, 'index'])->name('appeal.index');
    Route::get('/appeal/create', [AppealController::class, 'create'])->name('appeal.create');
    Route::post('/appeal/store', [AppealController::class, 'store'])->name('appeal.store');
    Route::get('/appeal/{id}/edit', [AppealController::class, 'edit'])->name('appeal.edit');
	Route::put('/appeal/{id}', [AppealController::class, 'update'])->name('appeal.update');
	Route::get('/appeal/search', [AppealController::class, 'search'])->name('appeal.search');


    //Tin checker

    Route::get('/tin-checker/{tin}', [StockController::class, 'tinChecker'])->name('tinChecker');


    //Arrear routes
    Route::get('/arrears', [ArrearController::class, 'index'])->name('arrears');
    Route::post('/arrear', [ArrearController::class, 'store'])->name('arrearStore');
    Route::get('/arrear/edit', [ArrearController::class, 'edit'])->name('arrearEdit');
    Route::post('/arrear/edit', [ArrearController::class, 'update'])->name('arrearUpdate');
});



Route::middleware(['auth', 'role:range'])->name('range.')->group(function () {

    Route::get('/range-dashboard', [RangeController::class, 'index'])->name('dashboard');


    Route::get('range/arrears', [RangeController::class, 'RangeArrear'])->name('arrears');

    Route::get('range/arrears/sort/{circle}', [RangeController::class, 'RangeArrearSort'])->name('arrearssort');
});


Route::middleware(['auth', 'role:technical'])->name('technical.')->group(function () {

    Route::get('/technical-dashboard', [TechnicalController::class, 'index'])->name('dashboard');

    Route::get('technical/arrears', [TechnicalController::class, 'TechnicalArrear'])->name('arrears');

    Route::get('technical/arrears/sort/{circle}', [TechnicalController::class, 'TechnicalArrearSort'])->name('arrearssort');
});

Route::middleware(['auth', 'role:commissioner'])->name('commissioner.')->group(function () {

    Route::get('/commissioner-dashboard', [CommissionerController::class, 'index'])->name('dashboard');

    Route::get('commissioner/arrears', [ArrearController::class, 'CommissionerArrear'])->name('arrears');

    Route::get('commissioner/arrears/sort/{circle}', [ArrearController::class, 'CommissionerArrearSort'])->name('arrearssort');


    //User routes
    Route::get('commissioner/users', [UserController::class, 'index'])->name('users');


    Route::get('commissioner/users/create', [UserController::class, 'userCreate'])->name('user.create');

    Route::post('commissioner/user/store', [UserController::class, 'userStore'])->name('user.store');

    Route::get('commissioner/users/edit/{id}', [UserController::class, 'userEdit'])->name('user.edit');

    Route::post('commissioner/user/update/{id}', [UserController::class, 'userUpdate'])->name('user.update');

    Route::get('commissioner/user/delete/{id}', [UserController::class, 'userDelete'])->name('user.delete');


});



Route::get('/send-otp', [OTPController::class, 'sendOTP'])->name('sendOTP');
Route::get('/verify-otp', [OTPController::class, 'showVerifyOTPForm'])->name('verifyOTPForm');
Route::post('/verify-otp', [OTPController::class, 'verifyOTP'])->name('verifyOTP');
 