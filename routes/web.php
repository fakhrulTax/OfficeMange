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

use App\Http\Controllers\MovementController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\OTPController;

use App\Http\Controllers\SMSController;




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

    Route::get('stock/view/{id}', [StockController::class, 'view'])->name('stock.view');
    Route::get('/stock/editbyid', [StockController::class, 'stockEditByid'])->name('stockEditByid');
    Route::post('/stock/editbyid', [StockController::class, 'stockUpdateByid'])->name('stockUpdateByid');

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

    //Movement
    Route::get('/movement', [MovementController::class, 'index'])->name('movement.index');
    Route::post('/movement/store', [MovementController::class, 'store'])->name('movement.store');
    Route::get('/movement/{id}/edit', [MovementController::class, 'edit'])->name('movement.edit');
	Route::put('/movement/{id}', [MovementController::class, 'update'])->name('movement.update');
    Route::get('/movement/{id}/receive', [MovementController::class, 'receive'])->name('movement.receive');
    Route::put('/movement/receive/{id}', [MovementController::class, 'receiveUpdate'])->name('movement.receive.update');


    //Tin checker

    Route::get('/tin-checker/{tin}', [StockController::class, 'tinChecker'])->name('tinChecker');


    //Arrear routes
    Route::get('/arrears', [ArrearController::class, 'index'])->name('arrears');
    Route::post('/arrear', [ArrearController::class, 'store'])->name('arrearStore');
    Route::get('/arrear/edit', [ArrearController::class, 'edit'])->name('arrearEdit');
    Route::post('/arrear/edit', [ArrearController::class, 'update'])->name('arrearUpdate');

    //Settings
	Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
	Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
});



Route::middleware(['auth', 'role:range'])->name('range.')->group(function () {

    Route::get('/range-dashboard', [RangeController::class, 'index'])->name('dashboard');


    Route::get('range/arrears/{circle}', [RangeController::class, 'RangeArrear'])->name('arrears');

    Route::post('range/arrear', [RangeController::class, 'RangeArrearSort'])->name('arrearssort');
});


Route::middleware(['auth', 'role:technical'])->name('technical.')->group(function () {

    Route::get('/technical-dashboard', [TechnicalController::class, 'index'])->name('dashboard');

    Route::get('technical/arrears/{circle}', [TechnicalController::class, 'TechnicalArrear'])->name('arrears');

    Route::post('technical/arrear', [TechnicalController::class, 'TechnicalArrearSort'])->name('arrearssort');
});

Route::middleware(['auth', 'role:commissioner'])->name('commissioner.')->group(function () {

    Route::get('/commissioner-dashboard', [CommissionerController::class, 'index'])->name('dashboard');

    Route::get('commissioner/arrears/{circle}', [ArrearController::class, 'CommissionerArrear'])->name('arrears');

    Route::post('commissioner/arrear/', [ArrearController::class, 'CommissionerArrearSort'])->name('arrearssort');


    //User routes
    Route::get('commissioner/users', [UserController::class, 'index'])->name('users');


    Route::get('commissioner/users/create', [UserController::class, 'userCreate'])->name('user.create');

    Route::post('commissioner/user/store', [UserController::class, 'userStore'])->name('user.store');

    Route::get('commissioner/users/edit/{id}', [UserController::class, 'userEdit'])->name('user.edit');

    Route::post('commissioner/user/update/{id}', [UserController::class, 'userUpdate'])->name('user.update');

    Route::get('commissioner/user/delete/{id}', [UserController::class, 'userDelete'])->name('user.delete');

    //SMS routes

    Route::get('commissioner/sms', [SMSController::class, 'index'])->name('sms');
    Route::get('commissioner/sms/delete/{id}', [SMSController::class, 'delete'])->name('sms.delete');

});



Route::get('/send-otp', [OTPController::class, 'sendOTP'])->name('sendOTP');
Route::get('/verify-otp', [OTPController::class, 'showVerifyOTPForm'])->name('verifyOTPForm');
Route::post('/verify-otp', [OTPController::class, 'verifyOTP'])->name('verifyOTP');


Route::get('profile', [UserController::class, 'profile'])->name('profile');
Route::get('/password-reset', [UserController::class, 'showPasswordResetForm'])->name('passwordResetForm');
Route::post('/password-reset', [UserController::class, 'passwordReset'])->name('passwordReset');
 