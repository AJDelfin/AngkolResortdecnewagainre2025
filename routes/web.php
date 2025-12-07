<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('customers', App\Http\Controllers\Admin\CustomerController::class);
    Route::resource('employees', App\Http\Controllers\Admin\EmployeeController::class);
    Route::delete('employees/bulk-destroy', [App\Http\Controllers\Admin\EmployeeController::class, 'bulkDestroy'])->name('employees.bulk-destroy');
    Route::resource('rooms', App\Http\Controllers\Admin\RoomController::class);
    Route::resource('cottages', App\Http\Controllers\Admin\CottageController::class);
    Route::resource('food-packages', App\Http\Controllers\Admin\FoodPackageController::class);
    Route::delete('food-packages/bulk-destroy', [App\Http\Controllers\Admin\FoodPackageController::class, 'bulkDestroy'])->name('food-packages.bulk-destroy');
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('reservations', App\Http\Controllers\Admin\ReservationController::class);
    Route::resource('posts', App\Http\Controllers\Admin\PostController::class);
    Route::delete('posts/bulk-destroy', [App\Http\Controllers\Admin\PostController::class, 'bulkDestroy'])->name('posts.bulk-destroy');
    Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
    Route::resource('guests', App\Http\Controllers\Admin\CustomerController::class);
    Route::get('billing/export', [App\Http\Controllers\Admin\BillingController::class, 'export'])->name('billing.export');
    Route::delete('billing/bulk-destroy', [App\Http\Controllers\Admin\BillingController::class, 'bulkDestroy'])->name('billing.bulk-destroy');
    Route::resource('billing', App\Http\Controllers\Admin\BillingController::class);
    Route::resource('financial-reports', App\Http\Controllers\Admin\FinancialReportController::class);
    Route::delete('financial-reports/bulk-destroy', [App\Http\Controllers\Admin\FinancialReportController::class, 'bulkDestroy'])->name('financial-reports.bulk-destroy');
    Route::get('financial-reports/export', [App\Http\Controllers\Admin\FinancialReportController::class, 'export'])->name('financial-reports.export');
});

// Staff routes
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');
});

// Customer routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('dashboard');
});

Route::get('admin/login', [AuthenticatedSessionController::class, 'createAdmin'])->name('admin.login');
Route::post('admin/login', [AuthenticatedSessionController::class, 'storeAdmin'])->name('admin.login.submit');
Route::post('admin/logout', [AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');
