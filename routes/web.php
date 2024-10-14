<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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
        Route::post('/vendor/cases/{id}/update', [Controllers\Admin\CaseController::class, 'update'])->name('admin.case.update');
        Route::post('/cases/{case}/upload', [Controllers\Admin\CaseController::class, 'upload'])->name('admin.case.upload');
});


// Routes for Sales Role
Route::prefix('/sales')->middleware(['auth', 'role:Sales'])->group(function () {
    Route::get('/dashboard', [Controllers\Sales\SalesController::class, 'dashboard'])->name('sales.dashboard');
});

// Routes for Doctor Role
Route::prefix('/doctor')->middleware(['auth', 'role:Doctor'])->group(function () {
    Route::get('/dashboard', [Controllers\Doctor\DoctorController::class, 'dashboard'])->name('doctor.dashboard');
});

// Routes for MedicineVital Role
Route::prefix('/medicine')->middleware(['auth', 'role:MedicineVital'])->group(function () {
    Route::get('/dashboard', [Controllers\MedicineVital\MedicineController::class, 'dashboard'])->name('medicine.dashboard');
});

// Routes for Billing Role
Route::prefix('/billing')->middleware(['auth', 'role:Bill'])->group(function () {
    Route::get('/dashboard', [Controllers\Bill\BillingController::class, 'dashboard'])->name('billing.dashboard');
});

// Routes for Lab Role
Route::prefix('/lab')->middleware(['auth', 'role:Lab'])->group(function () {
    Route::get('/dashboard', [Controllers\Lab\LabController::class, 'dashboard'])->name('lab.dashboard');
});

// Routes for Dispatcher Role
Route::prefix('/dispatcher')->middleware(['auth', 'role:Dispatcher'])->group(function () {
    Route::get('/dashboard', [Controllers\Dispatcher\DispatcherController::class, 'dashboard'])->name('dispatcher.dashboard');
});

// Routes for TPA Role
Route::prefix('/tpa')->middleware(['auth', 'role:TPA'])->group(function () {
    Route::get('/dashboard', [Controllers\TPA\TpaController::class, 'dashboard'])->name('tpa.dashboard');
});

// Routes for PostSales Role
Route::prefix('/postsales')->middleware(['auth', 'role:PostSales'])->group(function () {
    Route::get('/dashboard', [Controllers\PostSales\PostSalesController::class, 'dashboard'])->name('postsales.dashboard');
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
});
