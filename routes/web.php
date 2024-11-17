<?php

use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\OptinController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'homepage'])->name('homepage');
Route::post('customer', [CustomerController::class, 'store'])->name('customer.store');
Route::get('check-order', [OrderController::class, 'checkOrderPage'])->name('customer.check.order.page');
Route::post('check-order', [OrderController::class, 'checkingOrder'])->name('customer.checking.order');
Route::get('survey/second-step', [OrderController::class, 'surveyStep2'])->name('order.survey.second-step');
Route::get('too-soon', [OrderController::class, 'tooSoon'])->name('order.too-soon');
Route::get('order-not-found', [OrderController::class, 'orderNotFound'])->name('order.order-not-found');
Route::get('already-requested', [OrderController::class, 'orderAlreadyRequested'])->name('order.already-requested');
Route::post('survey-action', [OrderController::class, 'orderSurveyAction'])->name('order.survey_action');
Route::get('share-review', [OrderController::class, 'shareReview'])->name('order.share_review');
Route::get('update-address', [OrderController::class, 'orderUpdateAddress'])->name('order.update_address');
Route::post('update-address', [OrderController::class, 'storeOrderAddress'])->name('order.store_address');
Route::get('confirm-address', [OrderController::class, 'confirmAddress'])->name('order.confirm_address');
Route::get('ship-product', [OrderController::class, 'shipProduct'])->name('order.ship_product');
Route::get('thank-you', [OrderController::class, 'thankYou'])->name('order.thankyou');
Route::get('homepage/redirection/{title}', [OptinController::class, 'homepage_redirection'])->name('optin.homepage_redirection');
Route::get('optin', [OptinController::class, 'optin'])->name('optin');
Route::post('optin/store-user-action', [OptinController::class, 'storeUserAction'])->name('optin.store_user_action');

Route::get('test', [OrderController::class, 'test'])->name('test');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', [AdminHomeController::class, 'index'])->name('dashboard');
    Route::get('customer/list', [AdminCustomerController::class, 'customerList'])->name('admin.customer.list');
    Route::get('customer/review/{data}', [AdminCustomerController::class, 'getCustomerReview'])->name('admin.customer.review');
    Route::get('customer/note/{data}', [AdminCustomerController::class, 'getCustomerNote'])->name('admin.customer.note');
    Route::post('customer/note', [AdminCustomerController::class, 'updateCustomerNote'])->name('admin.update.customer.note');
    Route::post('update/customer/contact', [AdminCustomerController::class, 'updateCustomerContact'])->name('admin.update.customer.contact');
    Route::get('customers/export-csv', [AdminCustomerController::class, 'exportCSV'])->name('customers.exportCSV');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('password/reset', [PasswordController::class, 'edit'])->name('password.edit');
    Route::post('update/password', [PasswordController::class, 'updatePassword'])->name('update.password');
    Route::post('/customer/order/retry/{customer}', [OrderController::class, 'retryOrder'])->name('customer.order.retry');

    Route::get('customer/order/retry/{data}', [OrderController::class, 'customerOrderRetry'])->name('customer.order.retry');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
});

require __DIR__ . '/auth.php';
