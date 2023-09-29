<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function(){
    Auth::routes();
});
Route::controller(LoginController::class)->group(function(){
    Route::get('/admin/login', 'user_login')->name('login');
    Route::post('/admin/login', 'submit_login')->name('admin.login');
});

Route::controller(HomeController::class)->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/c/{slug}', 'view_category')->name('category');
    Route::post('/vote-contestant', 'vote_contestant')->name('vote');
    Route::post('/free-vote', 'free_vote_contestant')->name('free.vote');
    Route::post('/contestant/vote-modal', 'vote_modal')->name('vote.modal');
    Route::get('/logout', 'logout')->name('logout');
});

// Payment Callback
Route::controller(PaymentController::class)->prefix('payments')->group(function(){
    Route::get('/paypal/success/', 'paypal_success')->name('paypal.success');
    Route::get('/paypal/cancel/', 'paypal_cancel')->name('paypal.cancel');
    Route::get('/flutter/success/', 'flutter_success')->name('flutter.success');
    Route::any('/momopayment/success', 'momo_success')->name('momo.success');
    Route::post('/stripe-payment', 'stripe_payment')->name('stripe.payment');
});

// Admin Routes
Route::controller(AdminController::class)->as('admin.')->middleware('admin')->prefix('admin')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/dashboard', 'index')->name('dashboard');
    Route::get('/profile', 'profile')->name('profile');
    Route::post('/profile', 'update_profile')->name('profile');
    // Categories
    Route::get('/categories', 'categories')->name('categories');
    Route::post('/category/create', 'create_category')->name('categories.create');
    Route::post('/category/edit/{id}', 'edit_category')->name('categories.edit');
    Route::get('/category/{slug}/contestants', 'category_contestants')->name('categories.contestant');
    Route::get('/category/del/{id}', 'delete_category')->name('categories.delete');
    // Contestants
    Route::get('/contestants', 'contestants')->name('contestants');
    Route::post('/contestant/create', 'create_contestant')->name('contestant.create');
    Route::post('/contestant/update/{id}', 'update_contestant')->name('contestant.update');
    Route::get('/contestant/delete/{id}', 'delete_contestant')->name('contestant.delete');
    //Reports
    Route::get('/results', [AdminController::class, 'all_results'])->name('results');
    Route::get('/result/category/{id}', [AdminController::class, 'view_result'])->name('viewresult');

    // Settings
    Route::get('/settings', 'settings')->name('settings');
    Route::post('/setting', 'update_settings')->name('setting.update');
    Route::post('/system', 'systemUpdate')->name('setting.sys_settings');
    Route::post('/setting/system', 'store_settings')->name('setting.store');
    Route::get('/settings/payments', 'payment_settings')->name('settings.payment');
    Route::get('/voting-history', 'vote_history')->name('voting.history');
    Route::get('/payment-history', 'payment_history')->name('payment.history');

});
