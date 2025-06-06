<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StaffLoginController;
use App\Http\Controllers\FrontLoginController;
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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is organized into two main groups: Backend and Frontend.
| Each group uses a separate session cookie to prevent login conflicts
| between backend (Owner/Admin) and frontend (Cashier) users.
|
*/

//==========================================================================
// BACKEND ROUTES (uses 'backend_session' cookie)
//==========================================================================
Route::middleware(['backend.session'])->group(function () {

    // --- Guest Backend Routes ---
    
    // Redirects for convenience
    Route::redirect('/backend', '/backend/login');
    Route::redirect('/admin', '/admin/login');
    Route::get('/login', fn() => redirect()->route('backend.login.form'))->name('login');

    // Owner Authentication
    Route::get('backend/register', [RegisterController::class, 'showRegistrationForm'])->name('backend.register.form');
    Route::post('backend/register', [RegisterController::class, 'registerBackend'])->name('backend.register');
    Route::get('backend/login', [LoginController::class, 'loginBackend'])->name('backend.login.form');
    Route::post('backend/login', [LoginController::class, 'authenticateBackend'])->name('backend.login');

    // Admin/Manager Staff Login (for Backend Access)
    Route::get('admin/login', [StaffLoginController::class, 'showLoginForm'])->name('backend.admin.login.form');
    Route::post('admin/login', [StaffLoginController::class, 'login'])->name('backend.admin.login.submit');


    // --- Authenticated Backend Routes ---
    // Protected by 'auth:web,staff' to allow Owners OR privileged Staff
    Route::middleware(['auth:web,staff'])->prefix('backend')->as('backend.')->group(function() {

        Route::get('dashboard', [DashboardController::class, 'dashBackend'])->name('dashboard');
        
        // Logout Routes
        Route::post('logout', [LoginController::class, 'logoutBackend'])->name('logout');
        Route::post('admin/logout', [StaffLoginController::class, 'logout'])->name('admin.logout');
        
        // Resource Controllers (uses route name prefix 'backend.')
        Route::resource('store', StoreController::class);
        Route::resource('category', ProductCategoryController::class);
        Route::resource('product', ProductController::class);
        Route::resource('modifier', ModifierController::class);

        // Other Single-Action Backend Routes
        Route::post('store/{store}/activate', [StoreController::class, 'activate'])->name('store.activate');
        Route::post('store/deactivate', [StoreController::class, 'deactivate'])->name('store.deactivate');
        Route::post('product/{product}/toggle', [ProductController::class, 'toggle'])->name('product.toggle');
        Route::post('modifier/{modifier}/toggle', [ModifierController::class, 'toggle'])->name('modifier.toggle');
        Route::get('logs', [LogController::class, 'index'])->name('logs.index');
        
        // Product Modifier Relationship
        Route::get('product/{product}/add-modifier', [ProductModifierController::class, 'create'])->name('product.add_modifier');
        Route::post('product/{product}/add-modifier', [ProductModifierController::class, 'store'])->name('product.add_modifier.store');
        Route::post('product/modifiers-by-category', [ProductModifierController::class, 'modifiersByCategory'])->name('product.modifiers_by_category');
        
        // Staff Management (prefixed with /store/{store_id})
        Route::prefix('store/{store_id}')->as('staff.')->group(function () {
            Route::get('staff', [StaffController::class, 'index'])->name('index');
            Route::get('staff/create', [StaffController::class, 'create'])->name('create');
            Route::post('staff', [StaffController::class, 'store'])->name('store');
            Route::get('staff/{user_id}/edit', [StaffController::class, 'edit'])->name('edit');
            Route::put('staff/{user_id}', [StaffController::class, 'update'])->name('update');
            Route::delete('staff/{user_id}', [StaffController::class, 'destroy'])->name('destroy');
            Route::post('staff/{user_id}/reset-password', [StaffController::class, 'resetpassword'])->name('resetpassword');
        });
    });
});


//==========================================================================
// FRONTEND ROUTES (uses 'frontend_session' cookie)
//==========================================================================
Route::middleware(['frontend.session'])->group(function () {

    // --- Guest Frontend Routes ---

    // Main entry point of the application
    Route::get('/', fn() => redirect()->route('frontend.login'));

    // Frontend Staff (Cashier) Login
    Route::get('brewcash/login', [FrontLoginController::class, 'showLoginForm'])->name('frontend.login');
    Route::post('brewcash/login', [FrontLoginController::class, 'login'])->name('frontend.login.submit');

    // Staff Password Reset
    Route::get('/staff/forgot', [FrontLoginController::class, 'showForgotForm'])->name('frontend.staff.forgot');
    Route::post('/staff/forgot', [FrontLoginController::class, 'verifyStaffInfo'])->name('frontend.staff.verify');
    Route::get('/staff/reset-confirm', [FrontLoginController::class, 'showResetConfirmForm'])->name('frontend.staff.reset.confirm');
    Route::post('/staff/reset-confirm', [FrontLoginController::class, 'processReset'])->name('frontend.staff.reset.process');


    // --- Authenticated Frontend Routes ---
    // Protected by 'auth:staff' for any logged-in staff member
    Route::middleware('auth:cashier')->group(function () {
        Route::get('front/dashboard', [CashierController::class, 'index'])->name('front.dashboard');
        Route::get('/product-by-category', [CashierController::class, 'productsByCategory'])->name('products.byCategory');
        
        // Order Management
        Route::prefix('orders')->as('orders.')->group(function() {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/ajax', [OrderController::class, 'ajaxList'])->name('ajax');
            Route::get('/{order_id}', [OrderController::class, 'show'])->name('show');
            Route::post('/', [OrderController::class, 'store'])->name('store');
            Route::post('/{orderId}/pay', [OrderController::class, 'pay'])->name('pay');
            Route::post('/{orderId}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        });
    });
    Route::post('logout', [FrontLoginController::class, 'logout'])->name('frontend.logout');
});