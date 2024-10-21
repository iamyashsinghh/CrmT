<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\Controller;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Route
Route::get('/', function () {
    return view('login');
})->name('home');

// Authentication Routes
Route::post('login', [Controllers\AuthController::class, 'login'])->name('login');
Route::get('logout', [Controllers\AuthController::class, 'logout'])->name('logout');


Route::post('/update-profile-image/{member_id?}', [Controllers\AuthController::class, 'update_profile_image'])->name('updateProfileImage');


// Routes for Admin Role
Route::prefix('/admin')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/dashboard', [Controllers\Admin\AdminController::class, 'dashboard'])->name('admin.dashboard');

    // User Management
    Route::get('users', [Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::get('users/getUsers', [Controllers\Admin\UserController::class, 'getUsers'])->name('admin.users.getUsers');
    Route::get('users/manage/{id?}', [Controllers\Admin\UserController::class, 'manage'])->name('admin.users.manage');
    Route::post('users/manage/{id?}', [Controllers\Admin\UserController::class, 'manage_process'])->name('admin.users.manage_process');
    // Delete user
    Route::get('users/{id}', [Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy'); // Delete user

    // cases
    Route::get('/cases/ajaxlist', [Controllers\Admin\CaseController::class, 'ajax_list'])->name('admin_case_ajax');
    Route::get('/cases', [Controllers\Admin\CaseController::class, 'index'])->name('admin.case.index');
    Route::post('/cases/store', [Controllers\Admin\CaseController::class, 'store'])->name('admin.case.store');
    Route::get('/cases/{id}', [Controllers\Admin\CaseController::class, 'show'])->name('admin.case.show');
    Route::post('/cases/{id}/update', [Controllers\Admin\CaseController::class, 'update'])->name('admin.case.update');
    Route::get('/cases-status-update/{cases_id}/{status?}', [Controllers\Admin\CaseController::class, 'cases_status_update'])->name('admin.caseStatus.update');
    Route::post('/cases-status-remark', [Controllers\Admin\CaseController::class, 'cases_status_remark'])->name('admin_cases_status_remark');
    Route::post('/cases/{id}/file_update', [Controllers\Admin\CaseController::class, 'update_files'])->name('admin.case.files.update');



    Route::get('wallets', [Controllers\Admin\WalletController::class, 'index'])->name('admin.wallets.index');
    Route::post('wallets', [Controllers\Admin\WalletController::class, 'store'])->name('admin.wallets.store');
    Route::get('wallets/ajax', [Controllers\Admin\WalletController::class, 'ajax'])->name('admin.wallets.ajax');

    Route::get('vendor/wallets', [Controllers\Admin\WalletController::class, 'index_vendor'])->name('admin.vendor.wallets.index');
    Route::get('vendor/wallets/ajax', [Controllers\Admin\WalletController::class, 'ajax_vendor'])->name('admin.vendor.wallets.ajax');
    Route::post('vendor/wallets', [Controllers\Admin\WalletController::class, 'vendor_update_status'])->name('admin.vendor.wallets.updateStatus');
});


// Routes for Sales Role
Route::prefix('/sales')->middleware(['auth', 'role:Sales'])->group(function () {
    Route::get('/dashboard', [Controllers\Sales\SalesController::class, 'dashboard'])->name('sales.dashboard');

    // cases
    Route::get('/cases/ajaxlist', [Controllers\Sales\CaseController::class, 'ajax_list'])->name('sales_case_ajax');
    Route::get('/cases', [Controllers\Sales\CaseController::class, 'index'])->name('sales.case.index');
    Route::get('/cases/{id}', [Controllers\Sales\CaseController::class, 'show'])->name('sales.case.show');
    Route::post('/cases/{id}/update', [Controllers\Sales\CaseController::class, 'update'])->name('sales.case.update');
});

// Routes for Doctor Role
Route::prefix('/doctor')->middleware(['auth', 'role:Doctor'])->group(function () {
    Route::get('/dashboard', [Controllers\Doctor\DoctorController::class, 'dashboard'])->name('doctor.dashboard');

    Route::get('/cases/ajaxlist', [Controllers\Doctor\CaseController::class, 'ajax_list'])->name('doctor_case_ajax');
    Route::get('/cases', [Controllers\Doctor\CaseController::class, 'index'])->name('doctor.case.index');
    Route::get('/cases/{id}', [Controllers\Doctor\CaseController::class, 'show'])->name('doctor.case.show');
    Route::post('/cases/{id}/update', [Controllers\Doctor\CaseController::class, 'update'])->name('doctor.case.update');
});

// Routes for MedicineVital Role
Route::prefix('/medicine')->middleware(['auth', 'role:MedicineVital'])->group(function () {
    Route::get('/dashboard', [Controllers\MedicineVital\MedicineController::class, 'dashboard'])->name('medicinevital.dashboard');
    Route::get('/cases/ajaxlist', [Controllers\MedicineVital\CaseController::class, 'ajax_list'])->name('medicinevital_case_ajax');
    Route::get('/cases', [Controllers\MedicineVital\CaseController::class, 'index'])->name('medicinevital.case.index');
    Route::get('/cases/{id}', [Controllers\MedicineVital\CaseController::class, 'show'])->name('medicinevital.case.show');
    Route::post('/cases/{id}/update', [Controllers\MedicineVital\CaseController::class, 'update'])->name('medicinevital.case.update');
});

// Routes for Billing Role
Route::prefix('/billing')->middleware(['auth', 'role:Bill'])->group(function () {
    Route::get('/dashboard', [Controllers\Bill\BillingController::class, 'dashboard'])->name('billing.dashboard');
    Route::get('/cases/ajaxlist', [Controllers\Bill\CaseController::class, 'ajax_list'])->name('bill_case_ajax');
    Route::get('/cases', [Controllers\Bill\CaseController::class, 'index'])->name('bill.case.index');
    Route::get('/cases/{id}', [Controllers\Bill\CaseController::class, 'show'])->name('bill.case.show');
    Route::post('/cases/{id}/update', [Controllers\Bill\CaseController::class, 'update'])->name('bill.case.update');
});

// Routes for Lab Role
Route::prefix('/lab')->middleware(['auth', 'role:Lab'])->group(function () {
    Route::get('/dashboard', [Controllers\Lab\LabController::class, 'dashboard'])->name('lab.dashboard');
    Route::get('/cases/ajaxlist', [Controllers\Lab\CaseController::class, 'ajax_list'])->name('lab_case_ajax');
    Route::get('/cases', [Controllers\Lab\CaseController::class, 'index'])->name('lab.case.index');
    Route::get('/cases/{id}', [Controllers\Lab\CaseController::class, 'show'])->name('lab.case.show');
    Route::get('/cases/{id}/update', [Controllers\Lab\CaseController::class, 'update'])->name('lab.case.update');
});

// Routes for Dispatcher Role
Route::prefix('/dispatcher')->middleware(['auth', 'role:Dispatcher'])->group(function () {
    Route::get('/dashboard', [Controllers\Dispatcher\DispatcherController::class, 'dashboard'])->name('dispatcher.dashboard');
    Route::get('/cases/ajaxlist', [Controllers\Dispatcher\CaseController::class, 'ajax_list'])->name('dispatcher_case_ajax');
    Route::get('/cases', [Controllers\Dispatcher\CaseController::class, 'index'])->name('dispatcher.case.index');
    Route::get('/cases/{id}', [Controllers\Dispatcher\CaseController::class, 'show'])->name('dispatcher.case.show');
    Route::post('/cases/{id}/update', [Controllers\Dispatcher\CaseController::class, 'update'])->name('dispatcher.case.update');
});

// Routes for PostSales Role
Route::prefix('/postsales')->middleware(['auth', 'role:PostSales'])->group(function () {
    Route::get('/dashboard', [Controllers\PostSales\PostSalesController::class, 'dashboard'])->name('postsales.dashboard');
    Route::get('/cases/ajaxlist', [Controllers\PostSales\CaseController::class, 'ajax_list'])->name('postsales_case_ajax');
    Route::get('/cases', [Controllers\PostSales\CaseController::class, 'index'])->name('postsales.case.index');
    Route::get('/cases/{id}', [Controllers\PostSales\CaseController::class, 'show'])->name('postsales.case.show');
    Route::post('/cases/{id}/update', [Controllers\PostSales\CaseController::class, 'update'])->name('postsales.case.update');
    Route::post('/cases/{id}/file_update', [Controllers\PostSales\CaseController::class, 'update_files'])->name('postsales.case.files.update');

    Route::post('/query/add', [Controllers\PostSales\CaseController::class, 'query_add'])->name('postsales.query.add');
});

// Routes for TPA Role
Route::prefix('/tpa')->middleware(['auth', 'role:TPA'])->group(function () {
    Route::get('/dashboard', [Controllers\TPA\TpaController::class, 'dashboard'])->name('tpa.dashboard');
    Route::get('/cases/ajaxlist', [Controllers\TPA\CaseController::class, 'ajax_list'])->name('tpa_case_ajax');
    Route::get('/cases', [Controllers\TPA\CaseController::class, 'index'])->name('tpa.case.index');
    Route::get('/cases/{id}', [Controllers\TPA\CaseController::class, 'show'])->name('tpa.case.show');

    Route::get('wallets', [Controllers\TPA\WalletController::class, 'index'])->name('tpa.wallets.index');
    Route::get('wallets/ajax', [Controllers\TPA\WalletController::class, 'ajax'])->name('tpa.wallets.ajax');
});

// Routes for Vendor Role
Route::prefix('/vendor')->middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/dashboard', [Controllers\Vendor\VendorController::class, 'dashboard'])->name('vendor.dashboard');

    Route::get('/cases/ajaxlist', [Controllers\Vendor\CaseController::class, 'ajax_list'])->name('vendor_case_ajax');
    Route::get('/cases', [Controllers\Vendor\CaseController::class, 'index'])->name('vendor.case.index');
    Route::post('/cases/store', [Controllers\Vendor\CaseController::class, 'store'])->name('vendor.case.store');
    Route::get('/cases/{id}', [Controllers\Vendor\CaseController::class, 'show'])->name('vendor.case.show');
    Route::post('/vendor/cases/{id}/update', [Controllers\Vendor\CaseController::class, 'update'])->name('vendor.case.update');
    Route::post('/cases/{case}/upload', [Controllers\Vendor\CaseController::class, 'upload'])->name('vendor.case.upload');

    Route::get('wallets', [Controllers\Vendor\WalletController::class, 'index'])->name('vendor.wallets.index');
    Route::get('wallets/ajax', [Controllers\Vendor\WalletController::class, 'ajax'])->name('vendor.wallets.ajax');
    Route::post('wallets/store', [Controllers\Vendor\WalletController::class, 'store'])->name('vendor.wallets.store');

});
