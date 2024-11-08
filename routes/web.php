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
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UpazilaController;
use App\Http\Controllers\TdsController;
use App\Http\Controllers\AdvanceController;
use App\Http\Controllers\RetarnController;
use App\Http\Controllers\ReopenController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\ContactPersonController;


Route::get('/', function () {
    if (auth()->check()) {
    if(Auth::user()->user_role == 'circle')
    {
    return redirect()->route('circle.dashboard');
    }
    elseif(Auth::user()->user_role == 'commissioner')
    {
    return redirect()->route('commissioner.dashboard');
    }
    elseif(Auth::user()->user_role == 'range')
    {
    return redirect()->route('range.dashboard');
    }
}

return view('auth.login');
});
Auth::routes();


// Circle group routes
Route::middleware(['auth', 'role:circle'])->name('circle.')->group(function () {
    
    Route::get('/circle-dashboard', [CircleController::class, 'index'])->name('dashboard');

    //Return 
    Route::get('/return/create', [RetarnController::class, 'create'])->name('return.create');  
    Route::post('/return/store', [RetarnController::class, 'store'])->name('return.store');  
    Route::get('/return/{id}/edit', [RetarnController::class, 'edit'])->name('return.edit');  
    Route::put('/return/{id}', [RetarnController::class, 'update'])->name('return.update');  
    Route::get('/return', [RetarnController::class, 'index'])->name('return.index');  
    Route::post('/return/registerSerial', [RetarnController::class, 'getRegisterSerial'])->name('return.register.serial');  
    Route::post('/return/checkTIN', [RetarnController::class, 'checkTIN'])->name('retarn.stock.check');
    Route::get('/return/{id}/ordersheet', [RetarnController::class, 'orderSheet'])->name('retarn.orderSheet');
    Route::get('/return/search', [RetarnController::class, 'filter'])->name('return.filter');  
    Route::post('/return/excle', [RetarnController::class, 'excel'])->name('return.excel');  

    //Stock Route
    Route::get('/stock', [StockController::class, 'index'])->name('stock');
    Route::post('/stock', [StockController::class, 'store'])->name('stockStore');
    Route::get('/stock/search', [StockController::class, 'circleSearch'])->name('stockSearch');
    Route::get('/stock/edit', [StockController::class, 'edit'])->name('stockEdit');    
    Route::post('/stock/edit', [StockController::class, 'update'])->name('stockUpdate');
    Route::get('stock/view/{id}', [StockController::class, 'view'])->name('stock.view');
    Route::get('/stock/editbyid', [StockController::class, 'stockEditByid'])->name('stockEditByid');
    Route::post('/stock/editbyid', [StockController::class, 'stockUpdateByid'])->name('stockUpdateByid');
    Route::get('/stock/evn/{tin}', [StockController::class, 'envelop'])->name('stock.env');   
    Route::get('/stock/register', [StockController::class, 'register'])->name('stock.register');      


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
    Route::post('/arrear/notice', [ArrearController::class, 'notice'])->name('arrear.notice');
    Route::get('/circle/arrears/search', [ArrearController::class, 'search'])->name('arrears.search');
    Route::get('/circle/arrears/register', [ArrearController::class, 'register'])->name('arrears.register');


     //Task routes
     Route::get('/circle/forward_dairy', [TaskController::class, 'index'])->name('task.index');
     Route::post('/circle/forward_dairy', [TaskController::class, 'store'])->name('task.store');
     Route::delete('/circle/forward_dairy/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
     Route::put('/circle/forward_dairy/{id}/update_status', [TaskController::class, 'updateStatus'])->name('task.updateStatus');
 

    //Settings
	Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
	Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');

    //TDS routes
    Route::get('/tds', [TdsController::class, 'index'])->name('tds.index');    
    Route::get('/tds/create', [TdsController::class, 'create'])->name('tds.create');     
    Route::post('/tds', [TdsController::class, 'store'])->name('tds.store');
    Route::get('/tds/create/zilla/{zilla_id}/upazila/{upazila_id}', [TdsController::class, 'createByUpazila'])->name('tds.create.upazila');
    Route::get('/tds/edit/{id}', [TdsController::class, 'edit'])->name('tds.edit');
    Route::post('/tds/edit/{id}', [TdsController::class, 'update'])->name('tds.update');
    Route::get('/circle/tds/upazila/organization', [UpazilaController::class, 'upazilaOrganization'])->name('tds.upazila.organization'); 
    Route::post('/circle/tds/organization', [OrganizationController::class, 'store'])->name('tds.organization.store');
    Route::get('/circle/tds/upazila/{upazial_id}/organization', [UpazilaController::class, 'upazilaOrganizationWithOrg'])->name('tds.upazilaSelected.organization');
    Route::delete('/circle/remove-organization/{upazilaId}/{organizationId}', [UpazilaController::class, 'removeOrganization'])->name('removeOrganization');
    Route::post('/circle/upazila/{upazilaId}/add-organizations', [UpazilaController::class, 'addSelectedOrganizations'])
    ->name('tds.upazilaSelected.addOrganizations');
    Route::get('/tds/delete/{id}', [TdsController::class, 'destroy'])->name('tds.destroy');
    Route::get('/tds/search', [TdsController::class, 'tdsSearch'])->name('tds.search');
    Route::get('/tds/report', [TdsController::class, 'tdsReport'])->name('tds.report');
    Route::get('/tds/report/upazila/{upzilaId}/organization', [TdsController::class, 'tdsReportbyOrgUpazila'])->name('tds.report.upzila.org');
    
    Route::get('/tds/contact-person', [ContactPersonController::class, 'index'])->name('tds.contactPerson');
    Route::get('/tds/contact-person/create', [ContactPersonController::class, 'create'])->name('tds.contactPerson.create');
    Route::post('/tds/contact-person', [ContactPersonController::class, 'store'])->name('tds.contactPerson.store');
    Route::get('/tds/contact-person/{contactPerson}/edit', [ContactPersonController::class, 'edit'])->name('tds.contactPerson.edit');
    Route::post('/tds/contact-person/{contactPerson}/update', [ContactPersonController::class, 'update'])->name('tds.contactPerson.update');
    Route::get('/tds/contact-person/search', [ContactPersonController::class, 'search'])->name('tds.contactPerson.search');
    
    
    //advance
    Route::get('/advance', [AdvanceController::class, 'advanceIndex'])->name('advance.index');
    Route::get('/advance/create', [AdvanceController::class, 'create'])->name('advance.create');
    Route::post('/advance', [AdvanceController::class, 'store'])->name('advance.store');
    Route::post('/advance/notice', [AdvanceController::class, 'notice'])->name('advance.notice');
    Route::get('/advance/register', [AdvanceController::class, 'register'])->name('advance.register');
    Route::get('/advance/edit/{id}', [AdvanceController::class, 'edit'])->name('advance.edit');
    Route::post('/advance/edit/{id}', [AdvanceController::class, 'update'])->name('advance.update');
    Route::get('/advance/search', [AdvanceController::class, 'search'])->name('advance.search');

    //Reopen
    Route::get('/reopen', [ReopenController::class, 'index'])->name('reopen.index');
    Route::get('/reopen/create', [ReopenController::class, 'create'])->name('reopen.create');
    Route::post('/reopen', [ReopenController::class, 'store'])->name('reopen.store');
    Route::get('/reopen/register', [ReopenController::class, 'register'])->name('reopen.register');
    Route::get('/reopen/edit/{reopen}', [ReopenController::class, 'edit'])->name('reopen.edit');
    Route::put('/reopen/edit/{reopen}', [ReopenController::class, 'update'])->name('reopen.update');
    Route::get('/reopen/search', [ReopenController::class, 'search'])->name('reopen.search');

    //Audit
    Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');
    Route::get('/audit/create', [AuditController::class, 'create'])->name('audit.create');
    Route::post('/audit', [AuditController::class, 'store'])->name('audit.store');
    Route::get('/audit/register', [AuditController::class, 'register'])->name('audit.register');
    Route::get('/audit/edit/{audit}', [AuditController::class, 'edit'])->name('audit.edit');
    Route::put('/audit/edit/{audit}', [AuditController::class, 'update'])->name('audit.update');
    Route::get('/audit/search', [AuditController::class, 'search'])->name('audit.search');

    //Notice Controller
    Route::post('/circle/notice/{tin}/183(3)', [NoticeController::class, 'notice183'])->name('notice.183');
    Route::post('/circle/notice/{tin}/179', [NoticeController::class, 'notice179'])->name('notice.179');
    Route::post('/circle/notice/{tin}/212', [NoticeController::class, 'notice212'])->name('notice.212');
    Route::post('/circle/notice/{tin}/280', [NoticeController::class, 'notice280'])->name('notice.280');
    Route::post('/circle/notice/{tin}/refix', [NoticeController::class, 'refix'])->name('notice.refix');
    Route::post('/circle/notice/{tin}/57', [NoticeController::class, 'notice57'])->name('notice.57');
    Route::post('/circle/notice/{tin}/demand', [NoticeController::class, 'demand'])->name('notice.demand');
    Route::post('/circle/notice/{tin}/orderSheet', [NoticeController::class, 'orderSheet'])->name('notice.order.sheet');


});



Route::middleware(['auth', 'role:range'])->name('range.')->group(function () {

    Route::get('/range-dashboard', [RangeController::class, 'index'])->name('dashboard');

    //Arrear
    Route::get('/range/arrear', [ArrearController::class, 'rangeArrear'])->name('arrear');
    Route::get('/range/arrear/circle/{circle}', [ArrearController::class, 'index'])->name('arrear.circle');
    Route::get('/range/arrear/circle/{circle}/search', [ArrearController::class, 'search'])->name('arrear.circle.search');
   

    //TDS Report
    Route::get('/range/tds/report', [TdsController::class, 'tdsRangeReport'])->name('tds.report');
    Route::get('/range/tds/report/assessment_year', [TdsController::class, 'tdsRangeReportYear'])->name('tds.year');
    Route::get('/range/tds/report/circle/{circle}', [TdsController::class, 'tdsReport'])->name('tds.report.circle');
    Route::get('/range/tds/report/circle/{circle}/upazila/{upazila}', [TdsController::class, 'tdsReportbyOrgUpazila'])->name('tds.report.circle.upazila');
    Route::get('/range/tds/report/circles/upazila/{upazila}', [TdsController::class, 'tdsReportbyOrgDistUpazila'])->name('tds.report.upazila');
    Route::get('/range/tds/contact-person', [ContactPersonController::class, 'index'])->name('tds.contactPerson');
    Route::get('/range/tds/contact-person/search', [ContactPersonController::class, 'search'])->name('tds.contactPerson.search');

    //Advance
    Route::get('/range/advance', [AdvanceController::class, 'advanceReport'])->name('advance.report');
    Route::get('/range/advance/circle/{circle}', [AdvanceController::class, 'advanceIndex'])->name('advance.circle');
    Route::get('/range/advance/circle/{circle}/search', [AdvanceController::class, 'search'])->name('advance.circle.search');

});


Route::middleware(['auth', 'role:technical'])->name('technical.')->group(function () {

    Route::get('/technical-dashboard', [TechnicalController::class, 'index'])->name('dashboard');

    Route::get('technical/arrears/{circle}', [TechnicalController::class, 'TechnicalArrear'])->name('arrears');

    Route::post('technical/arrear', [TechnicalController::class, 'TechnicalArrearSort'])->name('arrearssort');
});

Route::middleware(['auth', 'role:commissioner'])->name('commissioner.')->group(function () {

    Route::get('/commissioner-dashboard', [CommissionerController::class, 'index'])->name('dashboard');
    
    //Stock Route
    Route::get('/commissioner/stock', [StockController::class, 'commissionerIndex'])->name('stock');
    Route::get('/commissioner/stock/search', [StockController::class, 'search'])->name('stock.search');
    Route::post('/commissioner/stock/upload', [StockController::class, 'upload'])->name('stock.upload');
    Route::delete('commissioner/stock/{id}', [StockController::class, 'destroy'])->name('stock.delete');


    //Arrear Route
    Route::get('/commissioner/arrear', [ArrearController::class, 'commissionerArrear'])->name('arrear');
    Route::get('/commissioner/arrear/circle/{circle}', [ArrearController::class, 'index'])->name('arrear.circle');
    Route::get('/commissioner/arrear/circle/{circle}/search', [ArrearController::class, 'search'])->name('arrear.circle.search');

    //TDS
    Route::get('/tds/upazila', [UpazilaController::class, 'index'])->name('tds.upazila.index');
    Route::post('/tds/upazila', [UpazilaController::class, 'store'])->name('tds.upazila.store');
    Route::get('/tds/upazila/{id}', [UpazilaController::class, 'edit'])->name('tds.upazila.edit');
    Route::put('/tds/upazila/{id}', [UpazilaController::class, 'update'])->name('tds.upazila.update');
    Route::get('/commissioner/tds/contact-person', [ContactPersonController::class, 'index'])->name('tds.contactPerson');
    Route::get('/commissioner/tds/contact-person/search', [ContactPersonController::class, 'search'])->name('tds.contactPerson.search');
    
    //TDS Organization and Upazila Relation
    Route::get('/commissioner/tds/upazila/organization', [UpazilaController::class, 'upazilaOrganization'])->name('tds.upazila.organization');    
    Route::get('/commissioner/tds/upazila/{upazial_id}/organization', [UpazilaController::class, 'upazilaOrganizationWithOrg'])->name('tds.upazilaSelected.organization');
    Route::delete('/remove-organization/{upazilaId}/{organizationId}', [UpazilaController::class, 'removeOrganization'])->name('removeOrganization');
    Route::post('/upazila/{upazilaId}/add-organizations', [UpazilaController::class, 'addSelectedOrganizations'])
    ->name('tds.upazilaSelected.addOrganizations');

    //TDS Organization
    Route::get('/tds/organization', [OrganizationController::class, 'index'])->name('tds.organization.index');
    Route::post('/tds/organization', [OrganizationController::class, 'store'])->name('tds.organization.store');
    Route::get('/tds/organization/{id}', [OrganizationController::class, 'edit'])->name('tds.organization.edit');
    Route::put('/tds/organization/{organization}', [OrganizationController::class, 'update'])->name('tds.organization.update');

    //TDS Collection Panel Route
    Route::get('/tds/collection', [TdsController::class, 'collectionIndex'])->name('tds.collection.index');
    Route::get('/tds/collection/{zillaId}/zilla', [TdsController::class, 'collectionZilla'])->name('tds.collection.zilla');

    //TDS Report Routes
    Route::get('/tds-list', [TdsController::class, 'commissionTdsIndex'])->name('tdsList.index');
    Route::get('/tds/report/circle/{circle}', [TdsController::class, 'tdsReport'])->name('tds.report.circle');
    Route::get('/tds/report/circle/{circle}/upazila/{upazila}', [TdsController::class, 'tdsReportbyOrgUpazila'])->name('tds.report.circle.upazila');
    Route::get('/tds-list/search', [TdsController::class, 'commissionTdsSearch'])->name('tdsList.search');

    //Advance Route
    Route::get('/commissioner/advance', [AdvanceController::class, 'advanceReport'])->name('advance.index');
    Route::get('/commissioner/advance/circle/{circle}', [AdvanceController::class, 'advanceIndex'])->name('advance.circle');
    Route::get('/commissioner/advance/circle/{circle}/search', [AdvanceController::class, 'search'])->name('advance.circle.search');

    //Task routes
    Route::get('/forward_dairy', [TaskController::class, 'index'])->name('task.index');
    Route::post('/forward_dairy', [TaskController::class, 'store'])->name('task.store');
    Route::delete('/forward_dairy/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
    Route::put('/forward_dairy/{id}/update_status', [TaskController::class, 'updateStatus'])->name('task.updateStatus');


    //Collection routes
    Route::get('commissioner/collection', [CollectionController::class, 'CommissionerCollectionsindex'])->name('collection.index');
    Route::get('commissioner/collection/search', [CollectionController::class, 'CommissionerCollectionsSearch'])->name('collection.search');

    //User routes
    Route::get('commissioner/users', [UserController::class, 'index'])->name('users');
    Route::get('commissioner/users/create', [UserController::class, 'userCreate'])->name('user.create');
    Route::post('commissioner/user/store', [UserController::class, 'userStore'])->name('user.store');
    Route::get('commissioner/users/edit/{id}', [UserController::class, 'userEdit'])->name('user.edit');
    Route::post('commissioner/user/update/{id}', [UserController::class, 'userUpdate'])->name('user.update');
    Route::get('commissioner/user/delete/{id}', [UserController::class, 'userDelete'])->name('user.delete');

    //Settings
	Route::get('/commissioner/setting', [SettingController::class, 'index'])->name('setting.index');
	Route::post('/commissioner/setting', [SettingController::class, 'update'])->name('setting.update');
	Route::post('/commissioner/update/assessment_year', [SettingController::class, 'updateAssessmentYear'])->name('setting.update.assessment');


    //SMS routes
    Route::get('commissioner/sms', [SMSController::class, 'index'])->name('sms');
    Route::get('commissioner/sms/delete/{id}', [SMSController::class, 'delete'])->name('sms.delete');



   

});



Route::get('/send-otp', [OTPController::class, 'sendOTP'])->name('sendOTP');
Route::get('/verify-otp', [OTPController::class, 'showVerifyOTPForm'])->name('verifyOTPForm');
Route::post('/verify-otp', [OTPController::class, 'verifyOTP'])->name('verifyOTP');


Route::get('profile', [UserController::class, 'profile'])->name('profile');
Route::get('profile/{id}', [UserController::class, 'profileEdit'])->name('profile.edit');
Route::post('profile/{id}', [UserController::class, 'profileUpdate'])->name('profile.update');

Route::get('/password-reset', [UserController::class, 'showPasswordResetForm'])->name('passwordResetForm');
Route::post('/password-reset', [UserController::class, 'passwordReset'])->name('passwordReset');



//Zill to Upazilla to organization 
Route::get('/upazilla/{zilla}', [TdsController::class, 'upazilaList'])->name('upazilaList');
Route::get('/ogranization/{upazilla}', [TdsController::class, 'ogranizationList'])->name('ogranizationList');