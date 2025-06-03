<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductModifierController;
use App\Http\Controllers\ModifierController;
use App\Http\Controllers\LogController;

use App\Http\Controllers\FrontLoginController;

Route::get('/', function () {
    return redirect()->route('frontend.login');
});

Route::get('/backend', function () {
    return redirect()->route('backend.login');
});
//register
Route::get('backend/register', [RegisterController::class, 'showRegistrationForm'])->name('backend.register.form');
Route::post('backend/register', [RegisterController::class, 'registerBackend'])->name('backend.register');
//login
Route::get('backend/login', [LoginController::class, 'loginBackend'])->name('backend.login.form');
Route::post('backend/login', [LoginController::class, 'authenticateBackend'])->name('backend.login');
Route::post('backend/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout');
Route::get('login', function () {
    return redirect()->route('backend.login');
})->name('login');

Route::get('/product-by-category', [CashierController::class, 'productsByCategory'])->name('products.byCategory');

Route::middleware('auth')->group(function () {
    //dashboard
    Route::get('backend/dashboard', [DashboardController::class, 'dashBackend'])->name('backend.dashboard');
    //store CRUD
    Route::resource('backend/store', StoreController::class, ['as' => 'backend']);
    Route::post('backend/store/{store}/activate', [StoreController::class, 'activate'])->name('backend.store.activate');
    Route::post('backend/store/deactivate', [StoreController::class, 'deactivate'])->name('backend.store.deactivate');
    //category CRUD
    Route::resource('backend/category', ProductCategoryController::class, ['as' => 'backend']);
    //product CRUD
    Route::resource('backend/product', ProductController::class, ['as' => 'backend']);
    //modifier CRUD
    Route::resource('backend/modifier', ModifierController::class, ['as' => 'backend']);
    //product modifier CRUD
    Route::get('backend/product/{product}/add-modifier', [ProductModifierController::class, 'create'])->name('backend.product.add_modifier');
    Route::post('backend/product/{product}/add-modifier', [ProductModifierController::class, 'store'])->name('backend.product.add_modifier.store');
    // AJAX for modifiers by category
    Route::post('backend/product/modifiers-by-category', [ProductModifierController::class, 'modifiersByCategory'])->name('backend.product.modifiers_by_category');
    Route::get('backend/logs', [LogController::class, 'index'])->name('backend.logs.index');
    Route::post('/backend/staff/{store_id}/{user_id}/reset-password', [StaffController::class, 'resetPassword'])->name('backend.staff.resetpassword');
    //frontend HOME
    Route::get('front/dashboard', [CashierController::class, 'index'])->name('front.dashboard');
    // orders
    // Order listing page (with status tabbing)
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

    // Order details (already present, included for completeness)
    Route::get('orders/{order_id}', [OrderController::class, 'show'])->name('orders.show');

    // Store new order (AJAX)
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');

    // Pay and Cancel (already present)
    Route::post('orders/{orderId}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::post('orders/{orderId}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});
//STAFF CREATE
Route::prefix('backend/store/{store_id}')->middleware('auth')->group(function () {
    Route::get('staff', [StaffController::class, 'index'])->name('backend.staff.index');
    Route::get('staff/create', [StaffController::class, 'create'])->name('backend.staff.create');
    Route::post('staff', [StaffController::class, 'store'])->name('backend.staff.store');
    Route::get('staff/{user_id}/edit', [StaffController::class, 'edit'])->name('backend.staff.edit');
    Route::put('staff/{user_id}', [StaffController::class, 'update'])->name('backend.staff.update');
    Route::delete('staff/{user_id}', [StaffController::class, 'destroy'])->name('backend.staff.destroy');
});
////FRONT END////
Route::get('brewcash/login', [FrontLoginController::class, 'showLoginForm'])->name('frontend.login');
Route::post('brewcash/login', [FrontLoginController::class, 'login'])->name('frontend.login.submit');
Route::post('brewcash/logout', [FrontLoginController::class, 'logout'])->name('frontend.logout');
Route::post('/backend/staff/{store_id}/{user_id}/reset-password', [FrontLoginController::class, 'resetPassword'])->name('backend.staff.resetpassword');
// web.php
Route::get('/staff/forgot', [FrontLoginController::class, 'showForgotForm'])->name('frontend.staff.forgot');
Route::post('/staff/forgot', [FrontLoginController::class, 'processForgot'])->name('frontend.staff.forgot.process');

// Add these routes to your web.php
Route::post('/orders/{orderId}/pay', [\App\Http\Controllers\OrderController::class, 'pay'])->name('orders.pay');
Route::post('/orders/{orderId}/cancel', [\App\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');
Route::get('orders-ajax', [OrderController::class, 'ajaxList'])->name('orders.ajax');

Route::get('/staff/forgot', [FrontLoginController::class, 'showForgotForm'])->name('frontend.staff.forgot');

// 2. Verify the submitted information
Route::post('/staff/forgot/verify', [FrontLoginController::class, 'verifyStaffInfo'])->name('frontend.staff.verify');

// 3. Show the final confirmation page after successful verification
Route::get('/staff/reset-confirm', [FrontLoginController::class, 'showResetConfirmForm'])->name('frontend.staff.reset.confirm');

// 4. Process the final reset action
Route::post('/staff/reset-confirm', [FrontLoginController::class, 'processReset'])->name('frontend.staff.reset.process');
